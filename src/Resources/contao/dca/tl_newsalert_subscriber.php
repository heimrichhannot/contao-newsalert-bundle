<?php
///**
// * Contao Open Source CMS
// *
// * Copyright (c) 2017 Heimrich & Hannot GmbH
// *
// * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
// * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
// */
//
//$translator = System::getContainer()->get('translator');
//
//$GLOBALS['TL_DCA']['tl_newsalert_subscribers'] = [
//  'config' => [
//      'dataContainer' => 'Table',
//      'switchToEdit' => true,
//      'enableVersioning' => true,
//      'sql' => [
//          'keys' => [
//              'id' => 'primary',
//          ]
//      ]
//  ],
//  'list' => [
//      'sorting' => [
//          'mode' => 1,
//          'fields' => ['email'],
//          'headerFields' => ['email, topic'],
//          'flag' => 1,
//          'panelLayout' => 'debug;filter;sort,search,limit',
//      ],
//      'label' => [
//          'fields' => ['name'],
//          'format' => '%s',
//          'showColumns' => true,
//      ],
//      'global_operations' => [
//      ],
//      'operations' => [
//          'edit' => [
//              'label' => &$GLOBALS['TL_LANG']['tl_car']['edit'],
//              'href' => 'table=tl_car',
//              'icon' => 'edit.gif'
//          ],
//          'editheader' => [
//              'label' => &$GLOBALS['TL_LANG']['tl_car']['editheader'],
//              'href' => 'act=edit',
//              'icon' => 'header.gif',
//          ],
//          'copy' => [
//              'label' => &$GLOBALS['TL_LANG']['tl_car']['copy'],
//              'href' => 'act=copy',
//              'icon' => 'copy.gif',
//          ],
//          'delete' => [
//              'label' => &$GLOBALS['TL_LANG']['tl_car']['delete'],
//              'href' => 'act=delete',
//              'icon' => 'delete.gif',
//              'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
//          ],
//          'show' => [
//              'label' => &$GLOBALS['TL_LANG']['tl_car']['show'],
//              'href' => 'act=show',
//              'icon' => 'show.gif'
//          ]
//      ]
//  ]
//];