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
        //        'onsubmit_callback' => array
        //        (
        //            array('HeimrichHannot\Haste\Dca\General', 'setDateAdded'),
        //        ),
        'sql'              => [
            'keys' => [
                'id' => 'primary',
            ]
        ]
    ],
    'list'     => [
        'sorting'           => [
            'mode'         => 1,
            'fields'       => ['email', 'topic'],
            'headerFields' => ['email', 'topic'],
            'flag'         => 1,
            'panelLayout'  => 'debug;filter;sort,search,limit',
        ],
        'label'             => [
            'fields'      => ['email', 'topic'],
            'format'      => '%s',
            'showColumns' => true,
        ],
        'global_operations' => [],
        'operations'        => [
            'edit'   => [
                'href' => 'table=tl_newsalert_recipients',
                'icon' => 'edit.gif',
                'href' => 'act=edit'
            ],
            'copy'   => [
                'label' => &$GLOBALS['TL_LANG']['tl_newsalert_recipients']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif',
            ],
            'delete' => [
                'label'      => &$GLOBALS['TL_LANG']['tl_newsalert_recipients']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm']
                                . '\'))return false;Backend.getScrollOffset()"',
            ],
            'show'   => [
                'label' => &$GLOBALS['TL_LANG']['tl_newsalert_recipients']['show'],
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
                $translator->trans('hh.newsalert.tl_newsalert_recipients.email.name'),
                $translator->trans('hh.newsalert.tl_newsalert_recipients.email.desc')
            ],
            'sorting'   => true,
            'flag'      => 1,
            'inputType' => 'text',
            'eval'      => [
                'mandatory'      => true,
                'rgxp'           => 'email',
                'maxlength'      => 128,
                'decodeEntities' => true,
                'nospace'        => true,
                'tl_class'       => 'w50'
            ],
            //            'save_callback' => array
            //            (
            //                array('tl_newsletter_recipients', 'checkUniqueRecipient'),
            //                array('tl_newsletter_recipients', 'checkBlacklistedRecipient')
            //            ),
            'sql'       => "varchar(255) NOT NULL default ''"
        ],
        'topic'     => [
            'label'     => [
                $translator->trans('hh.newsalert.tl_newsalert_recipients.topic.name'),
                $translator->trans('hh.newsalert.tl_newsalert_recipients.topic.desc')
            ],
            'sorting'   => true,
            'inputType' => 'text',
            'eval'      => [
                'maxlength' => 128,
                'mandatory' => true,
                'nospace'   => true,
                'tl_class'  => 'w50'
            ],
            'sql'       => "varchar(255) NOT NULL default ''"
        ],
        'confirmed' => [
            'label'       => [
                $translator->trans('hh.newsalert.tl_newsalert_recipients.confirmed.name'),
                $translator->trans('hh.newsalert.tl_newsalert_recipients.confirmed.desc')
            ],
            'inputType'   => 'checkbox',
            'sql'         => "int(1) NOT NULL default 1",
            'eval'        => ['tl_class' => 'w50 clr', 'submitOnChange' => true],
        ],
        'ip'        => [
            'label'   => &$GLOBALS['TL_LANG']['tl_newsletter_recipients']['ip'],
            'search'  => true,
            'sorting' => true,
            'flag'    => 11,
            'eval'    => array('doNotCopy' => true),
            'sql'     => "varchar(64) NOT NULL default ''"
        ]
    ]
];