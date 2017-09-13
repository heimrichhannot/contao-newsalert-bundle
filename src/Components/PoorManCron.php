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


use Contao\ModuleModel;

class PoorManCron
{

    public function minutely() { $this->sendNewsalerts('minutely'); }
    public function hourly()   { $this->sendNewsalerts('hourly');   }
    public function daily()    { $this->sendNewsalerts('daily');    }
    public function weekly()   { $this->sendNewsalerts('weekly');   }
    public function monthly()  { $this->sendNewsalerts('monthly');  }

    private function sendNewsalerts($strInterval)
    {
        $objModules = ModuleModel::findBy(
            ['newsalertSendType=?','newsalertPoorManCronIntervall=?'],
            ['poormancron', $strInterval]
        );
        if (!$objModules)
        {
            return;
        }
        $listener = \System::getContainer()->get('hh.contao-newsalert.listener.newspostedlistener');

        while($objModules->next())
        {
            $listener->callByModule($objModules->current());
        }
    }
}