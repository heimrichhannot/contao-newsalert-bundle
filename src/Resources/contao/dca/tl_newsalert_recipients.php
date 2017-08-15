<?php
/**
 * // * Contao Open Source CMS
 * // *
 * // * Copyright (c) 2017 Heimrich & Hannot GmbH
 * // *
 * // * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * // * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 * // */

$translator = System::getContainer()->get('translator');
//
$GLOBALS['TL_DCA']['tl_newsalert_recipients'] = [
    'config'   => [
        'dataContainer'    => 'Table',
        'switchToEdit'     => true,
        'enableVersioning' => false,
        'backlink'         => 'do=news',
        'label'            => $translator->trans('hh.newsalert.tl_newsalert_recipients.label'),
        'sql'              => [
            'keys' => [
                'id' => 'primary',
            ]
        ]
    ],
    'list'     => [
        'sorting'           => [
            'mode'         => 2,
            'fields'       => ['email', 'topic', 'confirmed'],
            'flag'         => 1,
            'panelLayout'  => 'debug;filter;sort,search,limit',
        ],
        'label'             => [
            'fields'      => ['email', 'topic', 'confirmed'],
            'format'      => '%s',
            'showColumns' => true,
        ],
        'global_operations' => [
            'newsalert_recipients' => [
                'label'               => $translator->trans('hh.newsalert.tl_newsalert_recipients.label'),
                'href'                => 'table=tl_newsalert_sent',
                'icon'                => 'db.svg',
            ]
        ],
        'operations'        => [
            'edit'   => [
                'label'     => [
                    $translator->trans('hh.newsalert.operations.edit.0'),
                    $translator->trans('hh.newsalert.operations.edit.1')
                ],
                'href' => 'act=edit',
                'icon' => 'edit.gif',
            ],
            'copy'   => [
                'label'     => [
                    $translator->trans('hh.newsalert.operations.copy.0'),
                    $translator->trans('hh.newsalert.operations.copy.1')
                ],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif',
            ],
            'delete' => [
                'label'     => [
                    $translator->trans('hh.newsalert.operations.delete.0'),
                    $translator->trans('hh.newsalert.operations.delete.1')
                ],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm']
                                . '\'))return false;Backend.getScrollOffset()"',
            ],
            'show'   => [
                'label'     => [
                    $translator->trans('hh.newsalert.operations.show.0'),
                    $translator->trans('hh.newsalert.operations.show.1')
                ],
                'href'  => 'act=show',
                'icon'  => 'show.gif'
            ]
        ]
    ],
    'palettes' => [
        'default' => '{abonnement_legend},email,topic,confirmed'
    ],
    'fields'   => [
        'id'        => [
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ],
        'tstamp'    => [
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ],
        'email'     => [
            'label'     => [
                $translator->trans('hh.newsalert.tl_newsalert_recipients.email.0'),
                $translator->trans('hh.newsalert.tl_newsalert_recipients.email.1')
            ],
            'sorting'   => true,
            'flag'      => 1,
            'inputType' => 'text',
            'search'    => true,
            'eval'      => [
                'mandatory'      => true,
                'rgxp'           => 'email',
                'maxlength'      => 128,
                'decodeEntities' => true,
                'nospace'        => true,
                'tl_class'       => 'w50'
            ],
            'sql'       => "varchar(255) NOT NULL default ''"
        ],
        'topic'     => [
            'label'     => [
                $translator->trans('hh.newsalert.tl_newsalert_recipients.topic.0'),
                $translator->trans('hh.newsalert.tl_newsalert_recipients.topic.1')
            ],
            'sorting'   => true,
            'inputType' => 'select',
            'options_callback' => ['hh.contao-newsalert.newstopiccollection','getAllTopics'],
            'search'    => true,
            'eval'      => [
                'chosen'    => true,
                'maxlength' => 128,
                'mandatory' => true,
                'nospace'   => true,
                'tl_class'  => 'w50'
            ],
            'sql'       => "varchar(255) NOT NULL default ''"
        ],
        'confirmed' => [
            'label'       => [
                $translator->trans('hh.newsalert.tl_newsalert_recipients.confirmed.0'),
                $translator->trans('hh.newsalert.tl_newsalert_recipients.confirmed.1')
            ],
            'inputType'   => 'checkbox',
            'sorting'     => true,
            'default'     => 0,
            'sql'         => "int(1) NOT NULL default 0",
            'eval'        => ['tl_class' => 'w50 clr', 'submitOnChange' => true],
        ],
        'captcha' => [
            'label'       => [
                $translator->trans('hh.newsalert.tl_newsalert_recipients.captcha.0'),
                $translator->trans('hh.newsalert.tl_newsalert_recipients.captcha.1')
            ],
            'inputType' => 'captcha',
        ]
    ]
];

\HeimrichHannot\FormHybrid\FormHybrid::addOptInFieldToTable('tl_newsalert_recipients');
\HeimrichHannot\FormHybrid\FormHybrid::addOptOutFieldToTable('tl_newsalert_recipients');
\HeimrichHannot\Haste\Dca\General::addDateAddedToDca('tl_newsalert_recipients');