<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

/*
 * Modules
 */

use HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertRedirectModule;
use HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertSubscribeModule;

$GLOBALS['BE_MOD']['content']['news']['tables'][] = 'tl_newsalert_recipients';
$GLOBALS['BE_MOD']['content']['news']['tables'][] = 'tl_newsalert_sent';

$GLOBALS['FE_MOD']['huh_newsalert'][NewsalertSubscribeModule::MODULE_NAME] = 'HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertSubscribeModule';
$GLOBALS['FE_MOD']['huh_newsalert'][NewsalertRedirectModule::MODULE_NAME] = 'HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertRedirectModule';

/*
 * Models
 */

$GLOBALS['TL_MODELS']['tl_newsalert_recipients'] = 'HeimrichHannot\ContaoNewsAlertBundle\Models\NewsalertRecipientsModel';

/*
 * Cron
 */

$GLOBALS['TL_CRON']['monthly'][]    = ['HeimrichHannot\ContaoNewsAlertBundle\Components\PoorManCron', 'monthly'];
$GLOBALS['TL_CRON']['weekly'][]    = ['HeimrichHannot\ContaoNewsAlertBundle\Components\PoorManCron', 'weekly'];
$GLOBALS['TL_CRON']['daily'][]    = ['HeimrichHannot\ContaoNewsAlertBundle\Components\PoorManCron', 'daily'];
$GLOBALS['TL_CRON']['hourly'][]    = ['HeimrichHannot\ContaoNewsAlertBundle\Components\PoorManCron', 'hourly'];
$GLOBALS['TL_CRON']['minutely'][]    = ['HeimrichHannot\ContaoNewsAlertBundle\Components\PoorManCron', 'minutely'];


/*
 * Notification Center
 */

$arrTokens = [
    'huh_newsalert_topic_recipient',
    'huh_newsalert_news_headline',
    'huh_newsalert_news_subheadline',
    'huh_newsalert_news_teaser',
    'huh_newsalert_news_content',
    'huh_newsalert_news_enclosure_html',
    'huh_newsalert_news_enclosure_text',
    'huh_newsalert_news_url',
    'huh_newsalert_recipient_topics',
    'huh_newsalert_recipient_topic_count',
    'huh_newsalert_opt_out_html',
    'huh_newsalert_opt_out_text',
    'huh_newsalert_year',
    'huh_newsalert_root_url',
];

$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE'][\HeimrichHannot\ContaoNewsAlertBundle\EventListener\NewsPostedListener::NOTIFICATION_TYPE_NEWSALERT] = [
    \HeimrichHannot\ContaoNewsAlertBundle\EventListener\NewsPostedListener::NOTIFICATION_TYPE_NEW_ARTICLE => [
        'recipients'           => array_merge($arrTokens, ['admin_email', 'form_*', 'formconfig_*']),
        'email_subject'        => array_merge($arrTokens, ['form_*', 'formconfig_*', 'admin_email']),
        'email_text'           => array_merge($arrTokens, ['form_*', 'formconfig_*', 'formlabel_*', 'raw_data', 'admin_email']),
        'email_html'           => array_merge($arrTokens, ['form_*', 'formconfig_*', 'formlabel_*', 'raw_data', 'admin_email']),
        'file_name'            => array_merge($arrTokens, ['form_*', 'formconfig_*', 'admin_email']),
        'file_content'         => array_merge($arrTokens, ['form_*', 'formconfig_*', 'admin_email']),
        'email_sender_name'    => array('admin_email', 'form_*', 'formconfig_*'),
        'email_sender_address' => array('admin_email', 'form_*', 'formconfig_*'),
        'email_recipient_cc'   => array('admin_email', 'form_*', 'formconfig_*'),
        'email_recipient_bcc'  => array('admin_email', 'form_*', 'formconfig_*'),
        'email_replyTo'        => array('admin_email', 'form_*', 'formconfig_*'),
        'attachment_tokens'    => array('form_*', 'formconfig_*'),
    ]
];