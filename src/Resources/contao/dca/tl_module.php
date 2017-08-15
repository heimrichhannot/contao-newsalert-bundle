<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

$arrDca = &$GLOBALS['TL_DCA']['tl_module'];

$arrDca['palettes'][\HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertSubscribeModule::MODULE_NAME] =
    '{title_legend},name,headline,type;'
    .'{optin_legend},newsalertOptIn;'
    .'{optout_legend},formHybridAddOptOut;'
    .'{misc_legend},formHybridCustomSubmit;';

$arrDca['palettes']['__selector__'][] = 'newsalertOptIn';
$arrDca['palettes']['__selector__'][] = 'formHybridCustomSubmit';

$arrDca['subpalettes']['newsalertOptIn'] = 'formHybridOptInSuccessMessage,formHybridOptInNotification';
$arrDca['subpalettes']['formHybridCustomSubmit'] = 'formHybridSubmitLabel,formHybridSubmitClass';



$arrFields = [
    'newsalertOptIn'                         => [
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['formHybridAddOptIn'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class' => 'w50', 'submitOnChange' => true],
        'sql'       => "char(1) NOT NULL default ''",
    ],
];

$arrDca['fields'] = array_merge($arrDca['fields'], $arrFields);