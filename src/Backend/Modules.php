<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\ContaoNewsAlertBundle\Backend;


class Modules
{
    public static function getNewsalertModules()
    {
        $modules = \ModuleModel::findByType(\HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertSubscribeModule::MODULE_NAME);
        $module_list = [];
        while ($modules->next())
        {
            $module_list[$modules->id] = $modules->name;
        }
        return $module_list;
    }
}