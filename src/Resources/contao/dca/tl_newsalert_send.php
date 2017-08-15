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
$GLOBALS['TL_DCA']['tl_newsalert_send'] = [
    'config'   => [
        'dataContainer'    => 'Table',
        'switchToEdit'     => true,
        'enableVersioning' => false,
        'backlink'         => 'do=news&table=tl_newsalert_recipients',
        'label'            => $translator->trans('hh.newsalert.tl_newsalert_send.label'),
        'onload_callback'  => ['onload_callback' => [
            ['HeimrichHannot\Haste\Dca\General', 'setDateAdded', true]
        ]],
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
        'global_operations' => [],
        'operations'        => [
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
//    'palettes' => [
//        'default' => '{abonnement_legend},email,topic,confirmed'
//    ],
    'fields'   => [
        'id'        => [
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ],
        'pid' => array
        (
            'foreignKey'              => 'tl_news.id',
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
        ),
        'tstamp'    => [
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ],
        'topics'     => [
            'label'     => [
                $translator->trans('hh.newsalert.tl_newsalert_send.topics.0'),
                $translator->trans('hh.newsalert.tl_newsalert_send.topics.1')
            ],
            'sorting'   => true,
            'inputType' => 'text',
            'search'    => true,
            'sql'       => "varchar(255) NOT NULL default ''"
        ],
        'senddate' => [
            'label'     => [
                $translator->trans('hh.newsalert.tl_newsalert_send.senddate.0'),
                $translator->trans('hh.newsalert.tl_newsalert_send.senddate.1')
            ],
            'sorting' => true,
            'eval'    => ['rgxp' => 'datim', 'doNotCopy' => true],
            'sql'     => "int(10) unsigned NOT NULL default '0'",
        ],
        'count_messages' => [
            'label'     => [
                $translator->trans('hh.newsalert.tl_newsalert_send.count_messages.0'),
                $translator->trans('hh.newsalert.tl_newsalert_send.count_messages.1')
            ],
            'sorting' => true,
            'eval'    => ['doNotCopy' => true],
            'sql'     => "int(10) unsigned NOT NULL default '0'",
        ],

    ]
];

\HeimrichHannot\Haste\Dca\General::addDateAddedToDca('tl_newsalert_send');