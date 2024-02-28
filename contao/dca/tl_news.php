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
 * Callbacks
 */
$dc['config']['onsubmit_callback'][] = ['huh.newsalert.listener.newsposted','onSubmitCallback'];

/*
 * Palettes
 */


$palette = \Contao\CoreBundle\DataContainer\PaletteManipulator::create();
$palette->addField('newsalert_sent', 'publish_legend')
    ->applyToPalette('default', 'tl_news');

/*
 * Fields
 */

$fields = [
    'newsalert_sent' => [
        'label'     => [
            $translator->trans('hh.newsalert.tl_news.newsalert_sent.0'),
            $translator->trans('hh.newsalert.tl_news.newsalert_sent.1')
        ],
        'inputType' => 'checkbox',
        'exclude'   => true,
        'default'   => 0,
        'sql'       => "int(1) NOT NULL default '1'",
        'eval'      => ['tl_class' => 'w50'],
    ]
];

$dc['fields'] = array_merge($dc['fields'], $fields);