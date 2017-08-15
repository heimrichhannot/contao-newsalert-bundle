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
$strTable = 'tl_newsalert_sent';

//
$GLOBALS['TL_DCA'][$strTable] = [
    'config'   => [
        'dataContainer'    => 'Table',
        'switchToEdit'     => true,
        'enableVersioning' => false,
        'backlink'         => 'do=news&table=tl_newsalert_recipients',
        'label'            => $translator->trans('hh.newsalert.tl_newsalert_sent.label'),
        'sql'              => [
            'keys' => [
                'id' => 'primary',
            ]
        ]
    ],
    'list'     => [
        'sorting'           => [
            'mode'         => 2,
            'fields'       => ['senddate DESC'],
            'flag'         => 8,
            'panelLayout'  => 'debug;filter;sort,search,limit',
        ],
        'label'             => [
            'fields'      => ['senddate', 'pid:tl_news.headline', 'topics', 'count_messages'],
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
            'label'     => [
                $translator->trans('hh.newsalert.tl_newsalert_sent.pid.0'),
                $translator->trans('hh.newsalert.tl_newsalert_sent.pid.1')
            ],
            'foreignKey'              => 'tl_news.id',
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
        ),
        'tstamp'    => [
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ],
        'topics'     => [
            'label'     => [
                $translator->trans('hh.newsalert.tl_newsalert_sent.topics.0'),
                $translator->trans('hh.newsalert.tl_newsalert_sent.topics.1')
            ],
            'sorting'   => true,
            'inputType' => 'text',
            'search'    => true,
            'sql'       => "varchar(255) NOT NULL default ''"
        ],
        'senddate' => [
            'label'     => [
                $translator->trans('hh.newsalert.tl_newsalert_sent.senddate.0'),
                $translator->trans('hh.newsalert.tl_newsalert_sent.senddate.1')
            ],
            'inputType' => 'text',
            'exclude' => true,
            'sorting' => true,
            'flag'    => 6,
            'eval'    => ['rgxp' => 'datim', 'datepicker' => true, 'doNotCopy' => true, 'sort' => 12],
            'sql'     => "int(10) unsigned NOT NULL default '0'",
        ],
        'count_messages' => [
            'label'     => [
                $translator->trans('hh.newsalert.tl_newsalert_sent.count_messages.0'),
                $translator->trans('hh.newsalert.tl_newsalert_sent.count_messages.1')
            ],
            'sorting' => true,
            'eval'    => ['doNotCopy' => true],
            'sql'     => "int(10) unsigned NOT NULL default '0'",
        ],
    ]
];