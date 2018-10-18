<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0+
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\Modules;

use Contao\Module;
use Contao\ModuleModel;
use Contao\System;
use Patchwork\Utf8;
use Symfony\Component\DependencyInjection\Container;

class NewsalertRedirectModule extends Module
{
    const MODULE_NAME = 'contao-newsalert-redirect';

    /**
     * @var Container
     */
    protected $container;

    protected $topic;
    protected $success = 'error';
    protected $opt = 'none';
    protected $strTemplate = 'mod_newsalert_redirect';

    /**
     * Initialize the object.
     *
     * @param ModuleModel $objModule
     * @param string      $strColumn
     */
    public function __construct(ModuleModel $objModule, string $strColumn = 'main')
    {
        $this->container = System::getContainer();
        parent::__construct($objModule, $strColumn);
    }

    /**
     * Parse the template.
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE === 'BE') {
            /** @var BackendTemplate|object $objTemplate */
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### '.Utf8::strtoupper($GLOBALS['TL_LANG']['FMD'][static::MODULE_NAME][0]).' ###';
//            $objTemplate->title = 'Newsalert Redirect';
            $objTemplate->id = $this->id;
//            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id='.$this->id;

            return $objTemplate->parse();
        }

        $session = $this->container->get('session');
        if ($session->has('contao_newsalert_success')) {
            $this->success = $session->get('contao_newsalert_success') ? 'success' : 'error';
        }
        $this->topic = $session->get('contao_newsalert_topic');
        $session->has('contao_newsalert_opt') ? $this->opt = $session->get('contao_newsalert_opt') : true;

        $session->remove('contao_newsalert_success');
        $session->remove('contao_newsalert_topic');
        $session->remove('contao_newsalert_opt');

        $this->strWrapperId .= $this->id;

        return parent::generate();
    }

    /**
     * Compile the current element.
     */
    protected function compile()
    {
        $translator = $this->container->get('translator');
        $strMessageId = 'hh.newsalert.module_redirect.opt'.$this->opt.'.'.$this->success.'.';
        $this->Template->headline = $translator->trans($strMessageId.'head');
        $this->Template->wrapperClass = $this->strWrapperClass;
        $this->Template->wrapperId = $this->strWrapperId;

        $this->Template->strMessage = $translator->trans($strMessageId.'message', [
            '%topic%' => $this->topic,
        ]);
    }
}
