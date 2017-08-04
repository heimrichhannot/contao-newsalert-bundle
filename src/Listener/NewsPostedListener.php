<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\Listener;

use Contao\ContentModel;
use Contao\CoreBundle\Monolog\ContaoContext;
use Contao\DC_Table;
use Contao\Email;
use Contao\Newsletter;
use Contao\System;
use Model\Collection;
use NotificationCenter\Model\Notification;
use Psr\Log\LogLevel;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NewsPostedListener
{

    const NotificationCenterType = 'news_posted';

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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

        $objContents = \ContentModel::findPublishedByPidAndTable($objArticle->id, 'tl_news');
        $topics = $this->container->get('hh.contao-newsalert.newstopiccollection')->getTopicsByItem($objArticle);
        $arrRecipients = $this->getRecipientsByTopic($topics);

        /**
         * @var Collection|Notification $objNotificationCollection
         */
        $objNotificationCollection = Notification::findByType(static::NotificationCenterType);
        if ($objNotificationCollection === null)
        {
            $this->container->get('monolog.logger.contao')->log(
                LogLevel::NOTICE,
                "No notification by type ".static::NotificationCenterType." was found. No newsalert send.",
                ['contao' => new ContaoContext(__CLASS__.'::'.__FUNCTION__, TL_GENERAL)]
            );
            return;
        }
        if ($objNotificationCollection->count() > 1)
        {
            $this->container->get('monolog.logger.contao')->addNotice('Multiple notifications by type '.static::NotificationCenterType.' found. Can lead to multiple notifications for the same person.');
        }

//        $strContentRaw = '';
//        $strContentHtml = '';

        $strContent = '';
        $strContent .= empty($objArticle->teaser) ? '' : $objArticle->teaser;

        if ($objContents !== null)
        {
            while ($objContents->next())
            {
                $item = $objContents->current();
                $title = deserialize($item->headline);
                $headline = '<'.$title['unit'].'>'.$title['value'].'</'.$title['unit'].'>';
                $strContent .= $headline;
                $strContent .= $item->text;
            }
        }

        $arrTokens = [];
        foreach ($arrRecipients as $email => $topics)
        {
            $arrTokens = [
                'hh_newsalert_topic_recipient' => $email,
                'hh_newsalert_recipient_topics' => implode(",", $topics),
                'hh_newsalert_news_title' => $objArticle->headline,
                'raw_data' => $strContent
            ];
            while ($objNotificationCollection->next())
            {
                $objNotification = $objNotificationCollection->current();
                $objNotification->send($arrTokens);
            }
            $objNotificationCollection->reset();
        }
        return;
    }

    /**
     * Return recipients email adresses and their subscribed topics
     * List is filtered, so every recipient is only once included in the list
     * (if he/she is not registered with multiple mail adresses),
     * even if he/she registered to multiple topics from the given list.
     *
     * @param array $arrTopic Simple list of topic names. Example ['Music','Live','Concert']
     *
     * @return array Key is the recipient mail adrress, values are the topics.
     *               Example: ['text@example.org' => ['Windows','MacOs','Linux']]
     */
    protected function getRecipientsByTopic($arrTopic = [])
    {
        $arrRecipients = [];
        foreach ($arrTopic as $item)
        {
            $recipients = static::recipients($item);

            foreach ($recipients as $recipient)
            {
                $arrRecipients[$recipient][] = $item;
            }
        }
        return $arrRecipients;
    }

    public static function recipients($topic)
    {
        $recipients = [];
        switch ($topic)
        {
            case "Abo":
            case "Abfallrecht":
                $recipients = [
                    't.koerner@heimrich-hannot.de',
                    'test@example.org'
                ];
                break;
            case "Abgeordnete":
            case "Sozialabgabenrecht":
                $recipients = [
                    't.koerner@heimrich-hannot.de',
                    'max.mustermann@example.org'
                ];
                break;
        }
        return $recipients;
    }
}