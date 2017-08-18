<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\EventListener;

use Contao\ContentModel;
use Contao\Controller;
use Contao\CoreBundle\Monolog\ContaoContext;
use Contao\DC_Table;
use Contao\Email;
use Contao\Environment;
use Contao\Frontend;
use Contao\Input;
use Contao\NewsArchiveModel;
use Contao\Newsletter;
use Contao\Request;
use Contao\System;
use HeimrichHannot\ContaoNewsAlertBundle\Models\NewsalertRecipientsModel;
use HeimrichHannot\ContaoNewsAlertBundle\Models\NewsalertSendModel;
use HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertSubscribeModule;
use HeimrichHannot\FormHybrid\TokenGenerator;
use HeimrichHannot\Modal\PageModel;
use Model\Collection;
use NotificationCenter\Model\Notification;
use Psr\Log\LogLevel;
use Symfony\Component\DependencyInjection\ContainerInterface;
use HeimrichHannot\Haste\Util\Url;

class NewsPostedListener
{

    const NOTIFICATION_TYPE_NEWSALERT = 'hh_newsalert';
    const NOTIFICATION_TYPE_NEW_ARTICLE = 'news_posted';

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->translator = $container->get('translator');
        $container->get('contao.framework')->initialize();
    }


    /**
     * @param DC_Table $dc
     *
     * @return void
     */
    public function newsPosted(DC_Table $dc)
    {
        $objArticle = \NewsModel::findPublishedByParentAndIdOrAlias($dc->activeRecord->id, [$dc->activeRecord->pid]);

        if (
            $objArticle === null or
            $objArticle->newsalert_activate == 0 or
            $objArticle->newsalert_send == 1 or
            $objArticle->published != 1
        )
        {
            return;
        }

        $topics = $this->container->get('hh.contao-newsalert.newstopiccollection')->getTopicsByItem($objArticle);
        $arrRecipients = $this->getRecipientsByTopic($topics);

        /**
         * @var Collection|Notification $objNotificationCollection
         */
        $objNotificationCollection = Notification::findByType(static::NOTIFICATION_TYPE_NEW_ARTICLE);
        if ($objNotificationCollection === null)
        {
            $this->container->get('monolog.logger.contao')->log(
                LogLevel::NOTICE,
                "No notification by type ".static::NOTIFICATION_TYPE_NEW_ARTICLE . " was found. No newsalert send.",
                ['contao' => new ContaoContext(__CLASS__.'::'.__FUNCTION__, TL_GENERAL)]
            );
            return;
        }
        if ($objNotificationCollection->count() > 1)
        {
            $this->container->get('monolog.logger.contao')->addNotice('Multiple notifications by type '.static::NOTIFICATION_TYPE_NEW_ARTICLE . ' found. Can lead to multiple notifications for the same person.');
        }

//        $strContentRaw = '';
//        $strContentHtml = '';

        $strContent = '';
        $strTeaser = empty($objArticle->teaser) ? '' : $objArticle->teaser;

        $objContents = \ContentModel::findPublishedByPidAndTable($objArticle->id, 'tl_news');
        if ($objContents !== null)
        {
            while ($objContents->next())
            {
                $item = $objContents->current();
                if (!empty($item->headline))
                {
                    $title = deserialize($item->headline);
                    $headline = '<'.$title['unit'].'>'.$title['value'].'</'.$title['unit'].'>';
                    $strContent .= $headline;
                }
                $strContent .= $item->text;
            }
        }

        $arrTokens = [];
        $intCountMails = 0;
        foreach ($arrRecipients as $email => $data)
        {
            $arrAllTopics = $this->getAllTopicsByRecipient($email);

            $strOptOutLinksHtml = '';
            $strOptOutLinksText = '';
            foreach ($arrAllTopics as $strTopic=>$strOptOutToken)
            {
                $strLink = Environment::get('url').$strOptOutToken;
                $strOptOutLinksHtml .= $strTopic.': <a href="'.$strLink.'">'.$this->translator->trans('hh.newsalert.notifications.unsubscribe').'</a><br />';
                $strOptOutLinksText .= $strTopic.' '.$this->translator->trans('hh.newsalert.notifications.unsubscribe').': '.$strLink.'\n';
            }

            $strTopics = implode(",", $data['topics']);

            $objNewsPage = \PageModel::findByPk(NewsArchiveModel::findById($objArticle->pid)->jumpTo);

            $strUrl = $this->container->get('contao.routing.url_generator')->generate($objNewsPage->alias).$objArticle->alias;
            $strRootUrl = Environment::get('url');
            $arrTokens = [
                'hh_newsalert_topic_recipient' => $email,
                'hh_newsalert_recipient_topics' => $strTopics,
                'hh_newsalert_recipient_topic_count' => count($data['topics']),
                'hh_newsalert_news_title' => $objArticle->headline,
                'hh_newsalert_news_teaser' => $strTeaser,
                'hh_newsalert_news_content' => $strContent,
                'hh_newsalert_news_url' => $strUrl,
                'hh_newsalert_opt_out_html' => $strOptOutLinksHtml,
                'hh_newsalert_opt_out_text' => $strOptOutLinksText,
                'hh_newsalert_year' => date('Y'),
                'hh_newsalert_root_url' => $strRootUrl,
                'raw_data' => $strContent
            ];

            if (isset($GLOBALS['TL_HOOKS']['hh_newsalert_customToken']) && is_array($GLOBALS['TL_HOOKS']['hh_newsalert_customToken']))
            {
                foreach ($GLOBALS['TL_HOOKS']['hh_newsalert_customToken'] as $callback)
                {
                    $arrTokens = System::importStatic($callback[0])->{$callback[1]}($objArticle, $arrTokens, $dc);
                }
            }

            while ($objNotificationCollection->next())
            {
                /**
                 * @var $objNotification Notification
                 */
                $objNotification = $objNotificationCollection->current();
                $objNotification->send($arrTokens);
                $intCountMails++;
            }

            $objNotificationCollection->reset();

            $objArticle->newsalert_send = 1;
            $objArticle->save();
        }
        $objNewsalertSend = new NewsalertSendModel();
        $objNewsalertSend->pid = $objArticle->id;
        $objNewsalertSend->topics = $topics;
        $objNewsalertSend->senddate = time();
        $objNewsalertSend->count_messages = $intCountMails;
        $objNewsalertSend->user = \BackendUser::getInstance()->id;
        $objNewsalertSend->save();
        return;
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
        foreach ($arrTopics as $strTopic)
        {
            $recipients = static::recipients($strTopic);
            if (!$recipients)
            {
                continue;
            }
            while ($recipients->next())
            {
                if (!$recipients->confirmed)
                {
                    continue;
                }
                $arrRecipients[$recipients->email]['topics'][] = $strTopic;
//
//
//                $strOptOutUrl = TokenGenerator::optOutTokens(
//                    NewsalertSubscribeModule::TABLE,
//                    $recipients->optOutToken
//                )['opt_out_link'];
//                $arrRecipients[$recipients->email]['topics'][$strTopic] = [
//                    'opt_out_link' => $strOptOutUrl
//                ];
            }
        }
        return $arrRecipients;
    }

    /**
     * Returns all topics by a recipient with opt out links
     *
     * @param $recipient string email address of the recipient
     *
     * @return array [Topic => Opt-out-link]
     */
    protected function getAllTopicsByRecipient($recipient)
    {
        $objAllRecipientsTopics = NewsalertRecipientsModel::findByEmail($recipient);
        $arrAllRecipientsTopics = [];
        while ($objAllRecipientsTopics->next())
        {
            $arrAllRecipientsTopics[$objAllRecipientsTopics->topic] = TokenGenerator::optOutTokens(
                NewsalertSubscribeModule::TABLE,
                $objAllRecipientsTopics->optOutToken
            )['opt_out_link'];
        }
        return $arrAllRecipientsTopics;
    }

    /**
     * @param $topic
     *
     * @return NewsalertRecipientsModel|null
     */
    public static function recipients($topic)
    {
        return NewsalertRecipientsModel::findByTopic($topic);
    }
}