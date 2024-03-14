<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

use Contao\ArrayUtil;
use Contao\CoreBundle\DataContainer\PaletteManipulator;

$dc         = &$GLOBALS['TL_DCA']['tl_news_archive'];
$translator = System::getContainer()->get('translator');

/*
 * List comments_legend
 */

ArrayUtil::arrayInsert($dc['list']['global_operations'], 1, [
    'newsalert_recipients' =>
        [
            'label' => $translator->trans('hh.newsalert.tl_news.newsalert_recipients'),
            'href'  => 'table=tl_newsalert_recipients',
            'icon'  => 'news.svg',
        ]
]);

$palette = PaletteManipulator::create();
$palette
    ->addLegend('newsalert_legend', 'comments_legend')
    ->addField('newsalert_activate', 'newsalert_legend')
    ->applyToPalette('default', 'tl_news_archive');


$dc['palettes']['__selector__'][]        = 'newsalert_activate';
$dc['subpalettes']['newsalert_activate'] = 'newsalert_configuration';

$fields = [
    'newsalert_activate' => [
        'label' => [
            $translator->trans('hh.newsalert.tl_news_archive.newsalert_activate.0'),
            $translator->trans('hh.newsalert.tl_news_archive.newsalert_activate.1')
        ],
        'inputType' => 'checkbox',
        'exclude' => true,
        'sql' => "char(1) NOT NULL default ''",
        'eval' => ['tl_class' => 'w50 clr', 'submitOnChange' => true],
    ],
    'newsalert_configuration' => [
        'label'            => [
            $translator->trans('hh.newsalert.tl_news_archive.newsalert_configuration.0'),
            $translator->trans('hh.newsalert.tl_news_archive.newsalert_configuration.1')
        ],
        'inputType'        => 'select',
        'exclude'          => true,
        'sql'              => "int(11) NOT NULL default '0'",
        'eval'             => ['tl_class' => 'w50'],
        'options_callback' => ['huh.newsalert.listener.callback.table.modules', 'getNewsalertModules']
    ]
];

$dc['fields'] = array_merge($dc['fields'], $fields);