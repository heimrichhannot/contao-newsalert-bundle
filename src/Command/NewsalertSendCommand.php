<?php

namespace HeimrichHannot\ContaoNewsAlertBundle\Command;

use Contao\CoreBundle\Command\AbstractLockedCommand;
use Contao\CoreBundle\Framework\ContaoFramework;
use HeimrichHannot\ContaoNewsAlertBundle\Models\NewsModel;
use HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertSubscribeModule;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


class NewsalertSendCommand extends AbstractLockedCommand
{
    /**
     * @var ContaoFramework
     */
    protected $framework;

    /**
     * @var Container
     */
    protected $container;


    public function __construct(ContaoFramework $framework, Container $container)
    {
        $this->framework = $framework;
        $this->container = $container;
        parent::__construct();
    }

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName('hh:newsalert:send')
            ->setDescription('Checks for unsend newsalerts and send found items.')
            ->setHelp('This commands checks news entities, if there are non sent newsalert. If so, the newsalert send event is triggered.')
            ->addArgument('module',InputArgument::OPTIONAL,'The module id, which contains the settings for the newsalert.')
            ->addOption('limit', 'l', InputOption::VALUE_REQUIRED, 'The max number of news to sent newsalert for.', 0)

        ;
    }

    /**
     * Executes the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null
     */
    protected function executeLocked(InputInterface $input, OutputInterface $output)
    {
        $this->framework->initialize();
        $output->writeln('<fg=green>Starting checking for unsend newsalert...</>');
        $objNews = NewsModel::findUnsentPublished($input->getOption('limit'));

        if ($objNews)
        {
            $output->writeln('Found '.$objNews->count().' unsend news entries.');
            if ($input->hasArgument('module'))
            {
                $intModule = $input->getArgument('module');
                $objModule = \ModuleModel::findById($intModule);
                $output->writeln("Try to use module ".$intModule);
                if (!$objModule)
                {
                    $output->writeln("<fg=red>Module $intModule not found. Try to find an existing module.</>");
                }
            }
            if (!$objModule || $objModule->type != NewsalertSubscribeModule::MODULE_NAME)
            {
                $objModule = \ModuleModel::findByType(NewsalertSubscribeModule::MODULE_NAME)->first();
            }
            if (!$objModule)
            {
                $output->writeln('<bg=red>No module found. Stopping execution.</>');
            }
            $output->writeln('Using module '.$objModule->id);
            $intSentCount = 0;

            while ($objNews->next())
            {
                if ($intSentAlerts = $this->container->get('hh.contao-newsalert.listener.newspostedlistener')
                    ->sendNewsalert($objNews->current(), $objModule->current(), $output) >= false
                )
                {

                    $intSentCount += $intSentAlerts;
                    $output->writeln('Newsalert sent for news article '.$objNews->id." ($intSentAlerts messages)");
                }
                else
                {
                    $output->writeln('<bg=red>Could not send newsalert for news article '.$objNews->id.'</>');
                }
            }

            $output->writeln("<fg=green>Finished. Sent $intSentCount notifications.</>");
        }
        else
        {
            $output->writeln('Found no unsend news entries.');
        }
    }


}