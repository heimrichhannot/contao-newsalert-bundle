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
$GLOBALS['TL_LANG']['FMD']['contao-newsalert-subscribe'] = ['Newsalert Anmeldung', 'Anmeldung für Newsalert-Topics'];
$GLOBALS['TL_LANG']['FMD']['contao-newsalert-redirect'] = ['Newsalert Redirect', 'Bestätigungsseitenmodul für Opt-in und Opt-out'];

$lang = &$GLOBALS['TL_LANG']['tl_module'];

/**
 * Fields
 */
$lang['newsalertSourceSelection'] = ['Quellen-Auswahl', 'Geben Sie hier an, welche Themen-Quellen für den Newsalert benutzt werden dürfen.'];
$lang['newsalertNoTopicSelection'] = ['Themenauswahl deaktivieren', 'Hier können Sie die Möglichkeit zur Auswahl eines Newsalert Themas deaktivieren und ein spezifisches Thema vorgeben.'];
$lang['newsalertOverwriteTopic'] = ['Spezifisches Thema', 'Setzen Sie hier das Thema, für welches die Anmeldung gelten soll.'];

$lang['newsalertPoorManCronIntervall']['minutely'] = 'Minütlich';
$lang['newsalertPoorManCronIntervall']['hourly'] = 'Stündlich';
$lang['newsalertPoorManCronIntervall']['daily'] = 'Täglich';
$lang['newsalertPoorManCronIntervall']['weekly'] = 'Wöchentlich';
$lang['newsalertPoorManCronIntervall']['monthly'] = 'Monatlich';

$lang['newsalertSendType'][NewsPostedListener::TRIGGER_ONSUBMIT] = 'Beim Speichern';
$lang['newsalertSendType']['poormancron'] = 'Contao Cronjob';
$lang['newsalertSendType']['customcron'] = 'Eigener Cronjob';



/*
 * Sources
 */
$lang['newsalertSources']['archive'] = 'Neuigkeiten-Archive';

/**
 * Legends
 */
$lang['trigger_legend'] = "Sendeevent";
$lang['newsalert_topic_legend'] = "Themen-Einstellungen";
$lang['message_handling_legend'] = "Nachrichten-Einstellungen";