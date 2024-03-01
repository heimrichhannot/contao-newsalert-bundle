<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

use HeimrichHannot\ContaoNewsAlertBundle\EventListener\NewsPostedListener;

$GLOBALS['TL_LANG']['FMD']['huh_newsalert'] = 'Newsalert';
$GLOBALS['TL_LANG']['FMD']['contao-newsalert-subscribe'] = array('Newsalert subscription', 'Subscribe for newsalert topic');
$GLOBALS['TL_LANG']['FMD']['contao-newsalert-redirect'] = array('Newsalert redirect', 'Module for redirect page for opt-in and opt-out');

$arrLang = &$GLOBALS['TL_LANG']['tl_module'];

/*
 * Fields
 */
$arrLang['newsalertSourceSelection'] = ['Source selection', 'Select topic sources for the newsalert.'];
$lang['newsalertNoTopicSelection'] = ['Disable topic selection', 'Disable topic selection field and set a custom topic.'];
$lang['newsalertOverwriteTopic'] = ['Specify topic', 'Set topic for the subscription.'];

$lang['newsalertPoorManCronIntervall']['minutely'] = 'minutely';
$lang['newsalertPoorManCronIntervall']['hourly'] = 'hourly';
$lang['newsalertPoorManCronIntervall']['daily'] = 'daily';
$lang['newsalertPoorManCronIntervall']['weekly'] = 'weekly';
$lang['newsalertPoorManCronIntervall']['monthly'] = 'monthly';

$lang['newsalertSendType'][NewsPostedListener::TRIGGER_ONSUBMIT] = 'On submit';
$lang['newsalertSendType']['poormancron'] = 'Contao cronjob';
$lang['newsalertSendType']['customcron'] = 'Custom cronjob';

/*
 * Sources
 */
$lang['newsalertSources']['archive'] = 'News archives';


/*
 * Legends
 */
$arrLang['trigger_legend'] = "Send event";
$lang['newsalert_topic_legend'] = "Topic settings";
$lang['message_handling_legend'] = "Message handling";