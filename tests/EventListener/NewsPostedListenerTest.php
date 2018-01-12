<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\ContaoNewsAlertBundle\Tests\EventListener;


use Contao\System;
use Contao\TestCase\ContaoTestCase;
use HeimrichHannot\ContaoNewsAlertBundle\EventListener\NewsPostedListener;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;
use Symfony\Component\Translation\IdentityTranslator;

class NewsPostedListenerTest extends ContaoTestCase
{
    protected function setUp()
    {
        $this->markTestIncomplete();
    }

    public function testGetRootUrl ()
    {
        $container = $this->mockContainer();
        $container->set('translator', new IdentityTranslator());
//        $router = new Router();
//        $router->setContext(new RequestContext('https://example.org'));
//        $container->set('router', $router);

        $listener = new NewsPostedListener($container);

        $this->assertEquals('https://example.org', $listener->getRootUrl());

    }

}