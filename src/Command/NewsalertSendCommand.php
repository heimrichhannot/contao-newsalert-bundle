<?php

/*
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0+
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\Command;

use Contao\CoreBundle\Command\AbstractLockedCommand;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\ModuleModel;
use Contao\System;
use HeimrichHannot\ContaoNewsAlertBundle\EventListener\NewsPostedListener;
use HeimrichHannot\ContaoNewsAlertBundle\Models\NewsModel;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;

/**
 * Contao Open Source CMS.
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
        $this->setName('huh:newsalert:send')
            ->setDescription('Checks for unsend newsalerts and send found items.')
            ->setHelp('This commands checks news entities, if there are non sent newsalert. If so, the newsalert send event is triggered.')
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
        $output->writeln('');
        $output->writeln('<fg=green>Starting checking for unsend newsalert...</>');

        $modules = $this->getCronModules();
        if (!$modules) {
            $output->writeln('<fg=red>No Modules to use with cronjob found. Stopping...</>');
            $output->writeln('');

            return 1;
        }
        $output->writeln('Found '.$modules->count().' modules.');

        $listener = $this->container->get('hh.contao-newsalert.listener.newspostedlistener');
        $archives = [];
        $count = 0;
        while ($modules->next()) {
            $output->writeln('Starting with module '.$modules->id.' ('.$modules->name.')');
            $archives = $listener->getArchiveIdsByModule($modules->current());
            if (empty($archives)) {
                $output->writeln('<fg=red>No news archives for current module. Continue...</>');
                continue;
            }
            $news = NewsModel::findUnsentPublished($input->getOption('limit'), $archives);
            if (!$news) {
                $output->writeln('<fg=red>No news found for current module. Continue...</>');
                continue;
            }
            while ($news->next()) {
                if ($news->newsalert_sent) {
                    continue;
                }
                if ($countCurrent = $listener->sendNewsalert($news->current(), $modules->current()) >= false) {
                    $count += $countCurrent;
                    $output->writeln('Newsalert sent for news article '.$news->id." ($countCurrent messages)");
                } else {
                    $output->writeln('<bg=red>Could not send newsalert for news article '.$news->id.'</>');
                }
            }
        }
        $output->writeln("<fg=green>Finished. Sent $count notifications.</>");
        $output->writeln('');

        return 0;
    }

    /**
     * Return cron modules
     *
     * @return \Contao\Model\Collection|ModuleModel|ModuleModel[]|null
     */
    public function getCronModules()
    {
        return ModuleModel::findBy('newsalertSendType', NewsPostedListener::TRIGGER_CRON);
    }
}
