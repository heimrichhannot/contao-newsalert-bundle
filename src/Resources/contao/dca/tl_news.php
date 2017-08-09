<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

$dc = &$GLOBALS['TL_DCA']['tl_news'];
$translator = System::getContainer()->get('translator');

/*
 * Hooks
 */
$dc['config']['onsubmit_callback'][] = ['hh.contao-newsalert.listener.newspostedlistener','newsPosted'];

/*
 * Palettes
 */

$dc['palettes']['__selector__'][] = 'newsalert_activate';

$palette = \Contao\CoreBundle\DataContainer\PaletteManipulator::create();
$palette->addField('newsalert_activate', 'publish_legend')
    ->applyToPalette('default', 'tl_news');

$dc['subpalettes']['newsalert_activate'] = 'newsalert_send';

/*
 * Fields
 */

$fields = [
    'newsalert_activate' => [
        'label'     => [
            $translator->trans('hh.newsalert.tl_news.newsalert_activate.name'),
            $translator->trans('hh.newsalert.tl_news.newsalert_activate.desc')
        ],
        'inputType' => 'checkbox',
        'exclude'   => true,
        'sql'       => "int(1) NOT NULL default 1",
        'eval'      => ['tl_class' => 'w50 clr', 'submitOnChange' => true],
    ],
    'newsalert_send' => [
        'label'     => [
            $translator->trans('hh.newsalert.tl_news.newsalert_send.name'),
            $translator->trans('hh.newsalert.tl_news.newsalert_send.desc')
        ],
        'inputType' => 'checkbox',
        'exclude'   => true,
        'sql'       => "int(1) NOT NULL default 0",
        'eval'      => ['tl_class' => 'w50'],
    ],
    'newsalert_sendtest' => [
        'label'     => [
            $translator->trans('hh.newsalert.tl_news.newsalert_send.name'),
            $translator->trans('hh.newsalert.tl_news.newsalert_send.desc')
        ],
        'inputType' => 'checkbox',
        'exclude'   => true,
        'sql'       => "int(1) NOT NULL default 0",
        'eval'      => ['tl_class' => 'w50'],
    ]
];

$dc['fields'] = array_merge($dc['fields'], $fields);