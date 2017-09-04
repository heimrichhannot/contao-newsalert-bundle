<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\ContaoNewsAlertBundle\Components;


use Contao\System;

class DcaAddon
{
    public static function addOnSubmitCallback($strTable)
    {
        $GLOBALS['TL_DCA'][$strTable]['config']['onsubmit_callback'][] = ['hh.contao-newsalert.listener.newspostedlistener', 'onSubmitCallback'];
    }

    public static function addCronExplanation()
    {
        return sprintf(
            '<div style="margin-left: 15px;margin-right: 15px;">%s</div>',
            System::getContainer()->get('translator')->trans('hh.newsalert.module_subscribe.newsalertCronjobExplanation')
        );
    }

//    public static function addPoorManCron()
//    {
//        $GLOBALS['TL_CRON']['daily']
//    }
}