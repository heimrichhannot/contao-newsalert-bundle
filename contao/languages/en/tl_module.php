<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

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

/*
 * Legends
 */
$arrLang['optin_legend'] = "Opt-in handling";
$arrLang['optout_legend'] = "Opt-out handling";
$arrLang['trigger_legend'] = "Send event";