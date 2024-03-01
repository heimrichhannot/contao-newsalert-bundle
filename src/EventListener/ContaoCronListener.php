<?php

namespace HeimrichHannot\ContaoNewsAlertBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCronJob;
use Contao\ModuleModel;

class ContaoCronListener
{
    public function __construct(private NewsPostedListener $newsPostedListener)
    {
    }

    #[AsCronJob('minutely')]
    public function minutely()
    {
        $this->sendNewsalerts('minutely');
    }

    #[AsCronJob('hourly')]
    public function hourly()
    {
        $this->sendNewsalerts('hourly');
    }

    #[AsCronJob('daily')]
    public function daily()
    {
        $this->sendNewsalerts('daily');
    }

    #[AsCronJob('weekly')]
    public function weekly()
    {
        $this->sendNewsalerts('weekly');
    }

    #[AsCronJob('monthly')]
    public function monthly()
    {
        $this->sendNewsalerts('monthly');
    }

    private function sendNewsalerts($strInterval)
    {
        $objModules = ModuleModel::findBy(
            ['newsalertSendType=?', 'newsalertPoorManCronIntervall=?'],
            ['poormancron', $strInterval]
        );
        if (!$objModules) {
            return;
        }

        while ($objModules->next()) {
            $this->newsPostedListener->callByModule($objModules->current());
        }
    }
}