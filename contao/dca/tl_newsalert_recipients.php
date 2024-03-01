<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0+
 */

use Contao\System;
use HeimrichHannot\ContaoNewsAlertBundle\DataContainer\NewsalertRecipientsContainer;
use HeimrichHannot\FormHybrid\FormHybrid;
use HeimrichHannot\UtilsBundle\Dca\DateAddedField;

$translator = System::getContainer()->get('translator');
$strTable = 'tl_newsalert_recipients';

DateAddedField::register($strTable);

$GLOBALS['TL_DCA'][$strTable] = [
    'config' => [
        'dataContainer' => 'Table',
        'switchToEdit' => true,
        'enableVersioning' => false,
        'backlink' => 'do=news',
        'label' => $translator->trans('hh.newsalert.tl_newsalert_recipients.label'),
        'sql' => [
            'keys' => [
                'id' => 'primary',
            ],
        ],
        'onsubmit_callback' => [['huh.newsalert.listener.callback.dca', 'addNewsalertRecipient']],
    ],
    'list' => [
        'sorting' => [
            'mode' => 2,
            'fields' => ['email', 'topic', 'confirmed'],
            'flag' => 1,
            'panelLayout' => 'debug;filter;sort,search,limit',
        ],
        'label' => [
            'fields' => ['email', 'topic', 'confirmed'],
            'format' => '%s',
            'showColumns' => true,
        ],
        'global_operations' => [
            'newsalert_sent' => [
                'label' => $translator->trans('hh.newsalert.tl_newsalert_sent.label'),
                'href' => 'table=tl_newsalert_sent',
                'icon' => 'db.svg',
            ],
        ],
        'operations' => [
            'edit' => [
                'label' => [
                    $translator->trans('hh.newsalert.operations.edit.0'),
                    $translator->trans('hh.newsalert.operations.edit.1'),
                ],
                'href' => 'act=edit',
                'icon' => 'edit.gif',
            ],
            'copy' => [
                'label' => [
                    $translator->trans('hh.newsalert.operations.copy.0'),
                    $translator->trans('hh.newsalert.operations.copy.1'),
                ],
                'href' => 'act=copy',
                'icon' => 'copy.gif',
            ],
            'delete' => [
                'label' => [
                    $translator->trans('hh.newsalert.operations.delete.0'),
                    $translator->trans('hh.newsalert.operations.delete.1'),
                ],
                'href' => 'act=delete',
                'icon' => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\''.($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null)
                                .'\'))return false;Backend.getScrollOffset()"',
            ],
            'show' => [
                'label' => [
                    $translator->trans('hh.newsalert.operations.show.0'),
                    $translator->trans('hh.newsalert.operations.show.1'),
                ],
                'href' => 'act=show',
                'icon' => 'show.gif',
            ],
        ],
    ],
    'palettes' => [
        'default' => '{abonnement_legend},email,topic,confirmed',
    ],
    'fields' => [
        'id' => [
            'sql' => 'int(10) unsigned NOT NULL auto_increment',
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'email' => [
            'label' => [
                $translator->trans('hh.newsalert.tl_newsalert_recipients.email.0'),
                $translator->trans('hh.newsalert.tl_newsalert_recipients.email.1'),
            ],
            'flag' => 1,
            'inputType' => 'text',
            'search' => true,
            'eval' => [
                'mandatory' => true,
                'rgxp' => 'email',
                'maxlength' => 128,
                'decodeEntities' => true,
                'nospace' => true,
                'tl_class' => 'w50',
            ],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'topic' => [
            'label' => [
                $translator->trans('hh.newsalert.tl_newsalert_recipients.topic.0'),
                $translator->trans('hh.newsalert.tl_newsalert_recipients.topic.1'),
            ],
            'filter' => true,
            'inputType' => 'select',
            'options_callback' => [NewsalertRecipientsContainer::class, 'onFieldsTopicOptions'],
            'eval' => [
                'chosen' => true,
                'maxlength' => 128,
                'mandatory' => true,
                'nospace' => false,
                'tl_class' => 'w50',
            ],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'confirmed' => [
            'label' => [
                $translator->trans('hh.newsalert.tl_newsalert_recipients.confirmed.0'),
                $translator->trans('hh.newsalert.tl_newsalert_recipients.confirmed.1'),
            ],
            'inputType' => 'checkbox',
            'filter' => true,
            'default' => 0,
            'sql' => 'int(1) NOT NULL default 0',
            'eval' => ['tl_class' => 'w50'],
        ],
        'captcha' => [
            'label' => [
                $translator->trans('hh.newsalert.tl_newsalert_recipients.captcha.0'),
                $translator->trans('hh.newsalert.tl_newsalert_recipients.captcha.1'),
            ],
            'inputType' => 'captcha',
        ],
    ],
];

FormHybrid::addOptInFieldToTable($strTable);
FormHybrid::addOptOutFieldToTable($strTable);