<?php

/*
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0+
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\Backend;

use Contao\ModuleModel;
use Contao\System;
use HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertSubscribeModule;

class Modules
{
    public static function getNewsalertModules()
    {
        $modules = System::getContainer()->get('contao.framework')->getAdapter(ModuleModel::class)->findByType(NewsalertSubscribeModule::MODULE_NAME);
        $module_list = [];
        while ($modules->next()) {
            $module_list[$modules->id] = $modules->name;
        }

        return $module_list;
    }
}
