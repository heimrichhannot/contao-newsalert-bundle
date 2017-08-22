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

$GLOBALS['BE_MOD']['content']['news']['tables'][] = 'tl_newsalert_recipients';
$GLOBALS['BE_MOD']['content']['news']['tables'][] = 'tl_newsalert_sent';

$GLOBALS['FE_MOD']['miscellaneous'][\HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertSubscribeModule::MODULE_NAME] = 'HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertSubscribeModule';
$GLOBALS['FE_MOD']['miscellaneous'][\HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertRedirectModule::MODULE_NAME] = 'HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertRedirectModule';

/*
 * Models
 */

$GLOBALS['TL_MODELS']['tl_newsalert_recipients'] = 'HeimrichHannot\ContaoNewsAlertBundle\Models\NewsalertRecipientsModel';

/*
 * Cron
 */

$GLOBALS['TL_CRON']['daily'][]    = ['HeimrichHannot\ContaoNewsAlertBundle\Components\PoorManCron', 'daily'];
$GLOBALS['TL_CRON']['hourly'][]    = ['HeimrichHannot\ContaoNewsAlertBundle\Components\PoorManCron', 'hourly'];

/*
 * Notification Center
 */

$arrTokens = [
    'hh_newsalert_topic_recipient',
    'hh_newsalert_news_title',
    'hh_newsalert_news_teaser',
    'hh_newsalert_news_content',
    'hh_newsalert_news_url',
    'hh_newsalert_recipient_topics',
    'hh_newsalert_recipient_topic_count',
    'hh_newsalert_opt_out_html',
    'hh_newsalert_opt_out_text',
    'hh_newsalert_year',
    'hh_newsalert_root_url',
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