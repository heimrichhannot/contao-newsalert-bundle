<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

use Contao\CoreBundle\DataContainer\PaletteManipulator;

$dca = &$GLOBALS['TL_DCA']['tl_news'];

/*
 * Callbacks
 */
$dca['config']['onsubmit_callback'][] = ['huh.newsalert.listener.newsposted', 'onSubmitCallback'];

/*
 * Palettes
 */


$palette = PaletteManipulator::create();
$palette->addField('newsalert_sent', 'publish_legend')
    ->applyToPalette('default', 'tl_news');

/*
 * Fields
 */

$dca['fields']['newsalert_sent'] = [
    'inputType' => 'checkbox',
    'exclude' => true,
    'default' => '',
    'sql' => "char(1) NOT NULL default '1'",
    'eval' => ['tl_class' => 'w50'],
];