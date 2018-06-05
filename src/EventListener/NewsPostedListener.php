<?php

/*
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0+
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\EventListener;

use Contao\ContentModel;
use Contao\Controller;
use Contao\CoreBundle\Monolog\ContaoContext;
use Contao\DC_Table;
use Contao\Environment;
use Contao\FrontendTemplate;
use Contao\Module;
use Contao\ModuleModel;
use Contao\NewsArchiveModel;
use Contao\PageModel;
use Contao\System;
use HeimrichHannot\ContaoNewsAlertBundle\Models\NewsalertRecipientsModel;
use HeimrichHannot\ContaoNewsAlertBundle\Models\NewsalertSendModel;
use HeimrichHannot\ContaoNewsAlertBundle\Models\NewsModel;
use HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertSubscribeModule;
use HeimrichHannot\FormHybrid\TokenGenerator;
use Model\Collection;
use NotificationCenter\Model\Notification;
use Psr\Log\LogLevel;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NewsPostedListener
{
    const NOTIFICATION_TYPE_NEWSALERT = 'hh_newsalert';
    const NOTIFICATION_TYPE_NEW_ARTICLE = 'news_posted';

    const TRIGGER_ONSUBMIT = 'onSubmit';
    const TRIGGER_CRON = 'customCron';

    protected $container;
    protected $translator;
    private $tokengenerator;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->translator = $container->get('translator');
        $this->tokengenerator = new TokenGenerator();
        $container->get('contao.framework')->initialize();
    }

    /**
     * Used for onSubmitCallback.
     *
     * @param DC_Table $dc
     *
     * @deprecated onSubmitCallback for newsalert marked deprecated and will be removed in future version.
     */
    public function onSubmitCallback(DC_Table $dc)
    {
        $archive = NewsArchiveModel::findByPk($dc->activeRecord->pid);
        if (!$archive or !$archive->newsalert_activate) {
            return;
        }
        $module = ModuleModel::findByPk($archive->newsalert_configuration);
        if (!$module or $module->newsalertSendType !== static::TRIGGER_ONSUBMIT) {
            return;
        }
        $objArticle = NewsModel::findPublishedByParentAndIdOrAlias($dc->activeRecord->id, [$dc->activeRecord->pid]);

        if (null === $objArticle or 1 === $objArticle->newsalert_sent
        ) {
            return;
        }
        $this->sendNewsalert($objArticle, $module);
    }

    /**
     * Trigger the send mechanism by model.
     *
     * @param ModuleModel $module
     */
    public function callByModule($module)
    {
        $archives = $this->getArchiveIdsByModule($module);
        if (empty($archives)) {
            return;
        }
        $objArticles = NewsModel::findUnsentPublished(0, $archives);
        if (!$objArticles) {
            return;
        }
        $count = 0;
        while ($objArticles->next()) {
            $count += $this->sendNewsalert($objArticles->current(), $module);
        }
    }

    /**
     * Get array with news archive ids which have given module as configuration.
     *
     * @param ModuleModel $module
     *
     * @return array|int
     */
    public function getArchiveIdsByModule($module)
    {
        $archives = NewsArchiveModel::findBy('newsalert_configuration', $module->id);
        $archivesIds = [];
        if ($archives) {
            while ($archives->next()) {
                if ($archives->newsalert_activate) {
                    $archivesIds[] = $archives->id;
                }
            }
        }

        return $archivesIds;
    }

    /**
     * @param             $article
     * @param ModuleModel $objModule
     *
     * @return bool|int False on failure, number of send messages on success
     */
    public function sendNewsalert($article, ModuleModel $objModule)
    {
        if (!$article or $article->newsalert_sent) {
            return false;
        }

        $topics = $this->container->get('huh.newsalert.topiccollection')->getTopicsByItem($article);
        $arrRecipients = $this->getRecipientsByTopic($topics);

        if (0 === count($arrRecipients)) {
            $article->newsalert_sent = 1;
            $article->save();
            $this->createSendModel($article, $topics, 0);

            return 0;
        }

        /**
         * @var Collection|Notification
         */
        $objNotificationCollection = Notification::findByType(static::NOTIFICATION_TYPE_NEW_ARTICLE);
        if (null === $objNotificationCollection) {
            $this->container->get('monolog.logger.contao')->log(
                LogLevel::NOTICE,
                'No notification by type '.static::NOTIFICATION_TYPE_NEW_ARTICLE.' was found. No newsalert send.',
                ['contao' => new ContaoContext(__CLASS__.'::'.__FUNCTION__, TL_GENERAL)]
            );

            return false;
        }
        if ($objNotificationCollection->count() > 1) {
            $this->container->get('monolog.logger.contao')->addNotice('Multiple notifications by type '.static::NOTIFICATION_TYPE_NEW_ARTICLE.' found. Can lead to multiple notifications for the same person.');
        }

        $strContent = '';
        $strTeaser = empty($article->teaser) ? '' : $article->teaser;

        $objContents = ContentModel::findPublishedByPidAndTable($article->id, 'tl_news');
        if (null !== $objContents) {
            while ($objContents->next()) {
                $item = $objContents->current();
                if (!empty($item->headline)) {
                    $title = deserialize($item->headline);
                    $headline = '<'.$title['unit'].'>'.$title['value'].'</'.$title['unit'].'>';
                    $strContent .= $headline;
                }
                $strContent .= $item->text;
            }
        }
        $intCountMails = 0;
        $rootUrl = $this->getRootUrl($objModule);

        foreach ($arrRecipients as $email => $data) {
            $arrAllTopics = $this->getAllTopicsByRecipient($email);
            $optOutLinks = $this->generateOptOutLinks($arrAllTopics, $rootUrl, $objModule);
            $strTopics = implode(',', $data['topics']);
            $strUrl = Controller::replaceInsertTags('{{news_url::' . $article->id . '}}', false);
            $enclosures = $this->addEnclosures($article);

            $arrTokens = [
                'huh_newsalert_topic_recipient' => $email,
                'huh_newsalert_recipient_topics' => $strTopics,
                'huh_newsalert_recipient_topic_count' => count($data['topics']),
                'huh_newsalert_news_headline' => $article->headline,
                'huh_newsalert_news_subheadline' => $article->subheadline,
                'huh_newsalert_news_teaser' => $strTeaser,
                'huh_newsalert_news_content' => $strContent,
                'huh_newsalert_news_enclosure_html' => $enclosures['html'],
                'huh_newsalert_news_enclosure_text' => $enclosures['text'],
                'huh_newsalert_news_url' => $strUrl,
                'huh_newsalert_opt_out_html' => $optOutLinks['html'],
                'huh_newsalert_opt_out_text' => $optOutLinks['text'],
                'huh_newsalert_year' => date('Y'),
                'huh_newsalert_root_url' => $rootUrl,
                'raw_data' => $strContent,
                // Fix cli error
                'salutation_user' => '',
                'salutation_form' => '',
            ];

            if (isset($GLOBALS['TL_HOOKS']['huh_newsalert_customToken']) && is_array($GLOBALS['TL_HOOKS']['huh_newsalert_customToken'])) {
                foreach ($GLOBALS['TL_HOOKS']['huh_newsalert_customToken'] as $callback) {
                    $arrTokens = System::importStatic($callback[0])->{$callback[1]}($article, $arrTokens);
                }
            }

            if (PHP_SAPI === 'cli') {
                unset($GLOBALS['TL_HOOKS']['sendNotificationMessage']);
            }

            while ($objNotificationCollection->next()) {
                /**
                 * @var Notification
                 */
                $objNotification = $objNotificationCollection->current();
                $objNotification->send($arrTokens);
                ++$intCountMails;
            }

            $objNotificationCollection->reset();


        }
        $article->newsalert_sent = 1;
        $article->save();
        $this->createSendModel($article, $topics, $intCountMails);

        return $intCountMails;
    }

    protected function createSendModel($objArticle, $arrTopics, $intCountMails)
    {
        $objNewsalertSend = new NewsalertSendModel();
        $objNewsalertSend->pid = $objArticle->id;
        $objNewsalertSend->topics = $arrTopics;
        $objNewsalertSend->senddate = time();
        $objNewsalertSend->count_messages = $intCountMails;
        $objNewsalertSend->user = $objArticle->author;
        $objNewsalertSend->save();
    }

    /**
     * Return recipients list with emails, topics and unsubscribe links
     * List is filtered, so every recipient is only once included in the list
     * (if he/she is not registered with multiple mail adresses),
     * even if he/she registered to multiple topics from the given list.
     *
     * @param array $arrTopics Simple list of topic names. Example ['Music','Live','Concert']
     *
     * @return array Key is the recipient mail adrress, values are the topics.
     *               Example: ['text@example.org' => ['Windows','MacOs','Linux']]
     */
    protected function getRecipientsByTopic($arrTopics = [])
    {
        $arrRecipients = [];
        foreach ($arrTopics as $strTopic) {
            $recipients = NewsalertRecipientsModel::findByTopic($strTopic);
            if (!$recipients) {
                continue;
            }
            while ($recipients->next()) {
                if (!$recipients->confirmed) {
                    continue;
                }
                $arrRecipients[$recipients->email]['topics'][] = $strTopic;
            }
        }

        return $arrRecipients;
    }

    /**
     * Returns all topics by a recipient with opt out links.
     *
     * @param $recipient string email address of the recipient
     *
     * @return array [Topic => Opt-out-link]
     */
    protected function getAllTopicsByRecipient($recipient)
    {
        $objAllRecipientsTopics = NewsalertRecipientsModel::findByEmail($recipient);
        $arrAllRecipientsTopics = [];
        while ($objAllRecipientsTopics->next()) {
            $arrAllRecipientsTopics[$objAllRecipientsTopics->topic] = $this->tokengenerator::optOutTokens(
                NewsalertSubscribeModule::TABLE,
                $objAllRecipientsTopics->optOutToken
            )['opt_out_link'];
        }

        ksort($arrAllRecipientsTopics);

        return $arrAllRecipientsTopics;
    }

    /**
     * @param array $topics
     * @param ModuleModel $config
     * @return array
     */
    protected function generateOptOutLinks (array $topics, string $url, ModuleModel $config)
    {
        $links = [
            'html' => '',
            'text' => ''
        ];

        if ($config->formHybridOptOutJumpTo)
        {
            $modulePage = PageModel::findByPk($config->formHybridOptOutJumpTo);
            if ($modulePage)
            {
                $url .= '/'.Controller::generateFrontendUrl($modulePage->row());
            }
        }

        foreach ($topics as $topic => $token)
        {
            $strLink            = $url . $token;
            $links['html'] .= $topic . ': <a href="' . $strLink . '">' . $this->translator->trans('hh.newsalert.notifications.unsubscribe') . '</a><br />';
            $links['text'] .= $topic . ' ' . $this->translator->trans('hh.newsalert.notifications.unsubscribe') . ': ' . $strLink . '\n';
        }
        return $links;
    }

    /**
     * @return string Current root url. Example: https://heimrich-hannot.de
     */
    public function getRootUrl(ModuleModel $config)
    {
        switch ($config->newsalertSendType)
        {
            case static::TRIGGER_CRON:
                $page = PageModel::findById($config->newsalertRootPage);
                if (!$page)
                {
                    $page = PageModel::findPublishedRootPages()->first();
                }
                if ($page && $page->dns)
                {
                    $url = ($page->useSSL ? 'https://' : 'http://') . $page->dns;
                    break;
                }
            default:
                $url = Environment::get('url');
        }
        return $url;
    }

    /**
     * @param NewsModel $article
     * @return array
     */
    protected function addEnclosures($article)
    {
        $enclosures = [
            'html' => '',
            'text' => ''
        ];
        if ($article->addEnclosure)
        {
            $template = new FrontendTemplate();
            Module::addEnclosuresToTemplate($template, $article->row());
            $enclosuresList = $template->enclosure;
            $countEnclosures = count($enclosuresList);
            $i = 0;
            foreach ($enclosuresList as $entry)
            {
                ++$i;
                $enclosures['text'] .= Environment::get('url').'/'.$entry['enclosure'];
                $enclosures['html'] .= '<a href="'.Environment::get('url').'/'.$entry['enclosure'].'" title="'.$entry['title'].'">'.$entry['name'].'</a> ('.$entry['filesize'].')';
                if ($i < $countEnclosures)
                {
                    $enclosures['text'] .= '\n';
                    $enclosures['html'] .= '<br />';
                }
            }
        }
        return $enclosures;
    }
}
