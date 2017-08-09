<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


$arrTokens = [
    'hh_newsalert_topic_recipient',
    'hh_newsalert_news_title',
    'hh_newsalert_recipient_topics'
];

$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE']['hh_newsalert'] = array
(
    \HeimrichHannot\ContaoNewsAlertBundle\Listener\NewsPostedListener::NotificationCenterType => [
        'recipients'           => array_merge($arrTokens, ['admin_email', 'form_*', 'formconfig_*']),
        'email_subject'        => array_merge($arrTokens, ['form_*', 'formconfig_*', 'admin_email']),
        'email_text'           => array_merge($arrTokens, ['form_*', 'formconfig_*', 'formlabel_*', 'raw_data', 'admin_email']),
        'email_html'           => array_merge($arrTokens, ['form_*', 'formconfig_*', 'formlabel_*', 'raw_data', 'admin_email']),
        'file_name'            => array('form_*', 'formconfig_*', 'admin_email'),
        'file_content'         => array('form_*', 'formconfig_*', 'admin_email'),
        'email_sender_name'    => array('admin_email', 'form_*', 'formconfig_*'),
        'email_sender_address' => array('admin_email', 'form_*', 'formconfig_*'),
        'email_recipient_cc'   => array('admin_email', 'form_*', 'formconfig_*'),
        'email_recipient_bcc'  => array('admin_email', 'form_*', 'formconfig_*'),
        'email_replyTo'        => array('admin_email', 'form_*', 'formconfig_*'),
        'attachment_tokens'    => array('form_*', 'formconfig_*'),
    ]
);

$GLOBALS['BE_MOD']['content']['newsalert'] = [
    'tables' => ['tl_newsalert_recipients']
];



//array_insert($GLOBALS['BE_MOD']['content']['news']['tables'])

