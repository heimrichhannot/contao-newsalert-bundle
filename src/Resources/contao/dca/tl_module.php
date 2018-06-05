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
$translator = System::getContainer()->get('translator');

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
$arrDca['subpalettes']['newsalertSendType_customCron'] = 'newsalertCronjobExplanation,newsalertRootPage';



$arrFields = [
    'newsalertOptIn'                         => [
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['formHybridAddOptIn'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class' => 'w50', 'submitOnChange' => true],
        'sql'       => "char(1) NOT NULL default ''",
    ],
    'newsalertSendType'                         => [
        'label'     => [
            $translator->trans('hh.newsalert.tl_module.newsalertSendType.0'),
            $translator->trans('hh.newsalert.tl_module.newsalertSendType.1')
        ],
        'exclude'   => true,
        'inputType' => 'select',
        'options'   => [
            \HeimrichHannot\ContaoNewsAlertBundle\EventListener\NewsPostedListener::TRIGGER_ONSUBMIT,
            'poormancron',
            'customCron'
        ],
        'eval'      => ['tl_class' => 'w50', 'submitOnChange' => true,'includeBlankOption'=>true],
        'sql'       => "varchar(12) NOT NULL default ''",
    ],
    'newsalertPoorManCronIntervall'                         => [
        'label'     => [
            $translator->trans('hh.newsalert.tl_module.newsalertPoorManCronIntervall.0'),
            $translator->trans('hh.newsalert.tl_module.newsalertPoorManCronIntervall.1')
        ],
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
    'newsalertRootPage' => [
        'label'      => [
            $translator->trans('hh.newsalert.tl_module.newsalertRootPage.0'),
            $translator->trans('hh.newsalert.tl_module.newsalertRootPage.1')
        ],
        'exclude'    => true,
        'inputType'  => 'select',
        'options_callback' => ['huh.newsalert.listener.callback.table.modules', 'getRootPagesWithDNS'],
        'foreignKey' => 'tl_page.title',
        'eval'       => ['mandatory' => true],
        'sql'        => "int(10) unsigned NOT NULL default '0'"
    ],

];

$arrDca['fields'] = array_merge($arrDca['fields'], $arrFields);