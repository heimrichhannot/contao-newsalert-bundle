<?php

$arrLang = &$GLOBALS['TL_LANG']['tl_nc_notification'];

$arrLang['type'][\HeimrichHannot\ContaoNewsAlertBundle\EventListener\NewsPostedListener::NOTIFICATION_TYPE_NEWSALERT] = 'Newsalert';
$arrLang['type'][\HeimrichHannot\ContaoNewsAlertBundle\EventListener\NewsPostedListener::NOTIFICATION_TYPE_NEW_ARTICLE] =
    ['Neuer Artikel', 'Dieser Benachrichtigungstyp wird verwendet, um den Newsalert zu senden.'];