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
    .'{trigger_legend},newsalertSendType;'
    .'{misc_legend},formHybridCustomSubmit;';

$arrDca['palettes'][\HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertRedirectModule::MODULE_NAME] =
    '{title_legend},name,headline,type;';

$arrDca['palettes']['__selector__'][] = 'newsalertOptIn';
$arrDca['palettes']['__selector__'][] = 'formHybridCustomSubmit';
$arrDca['palettes']['__selector__'][] = 'newsalertSendType';

$arrDca['subpalettes']['newsalertOptIn'] = 'formHybridOptInSuccessMessage,formHybridOptInNotification,formHybridOptInJumpTo';
$arrDca['subpalettes']['formHybridCustomSubmit'] = 'formHybridSubmitLabel,formHybridSubmitClass';
$arrDca['subpalettes']['newsalertSendType_poormancron'] = 'newsalertPoorManCronIntervall';
$arrDca['subpalettes']['newsalertSendType_customCron'] = 'newsalertCronjobExplanation';



$arrFields = [
    'newsalertOptIn'                         => [
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['formHybridAddOptIn'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class' => 'w50', 'submitOnChange' => true],
        'sql'       => "char(1) NOT NULL default ''",
    ],
    'newsalertSendType'                         => [
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['newsalertSendType'],
        'exclude'   => true,
        'inputType' => 'select',
        'options'   => ['onSubmit', 'poormancron', 'customCron'],
        'eval'      => ['tl_class' => 'w50', 'submitOnChange' => true,'includeBlankOption'=>true],
        'sql'       => "varchar(12) NOT NULL default ''",
    ],
    'newsalertPoorManCronIntervall'                         => [
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['newsalertPoorManCronIntervall'],
        'exclude'   => true,
        'inputType' => 'select',
        'options'   => ['minutely','hourly','daily','weekly','monthly'],
        'eval'      => ['tl_class' => 'w50', 'includeBlankOption'=>true],
        'sql'       => "varchar(12) NOT NULL default ''",
    ],
    'newsalertCronjobExplanation'                         => [
        'exclude'                 => true,
        'input_field_callback'    => ['HeimrichHannot\ContaoNewsAlertBundle\Components\DcaAddon', 'addCronExplanation']
    ],
];

$arrDca['fields'] = array_merge($arrDca['fields'], $arrFields);