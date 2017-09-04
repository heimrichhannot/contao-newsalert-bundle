<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

$dc         = &$GLOBALS['TL_DCA']['tl_news_archive'];
$translator = System::getContainer()->get('translator');

/*
 * List
 */

array_insert($GLOBALS['TL_DCA']['tl_news_archive']['list']['global_operations'], 1, [
    'newsalert_recipients' => [
        'label' => $translator->trans('hh.newsalert.tl_news.newsalert_recipients'),
        'href'  => 'table=tl_newsalert_recipients',
        'icon'  => 'news.svg',
    ]
]);