<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0+
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\Tests\EventListener;

use Contao\TestCase\ContaoTestCase;
use HeimrichHannot\ContaoNewsAlertBundle\EventListener\NewsPostedListener;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;
use Symfony\Component\Translation\IdentityTranslator;

class NewsPostedListenerTest extends ContaoTestCase
{
    protected function setUp()
    {
        $this->markTestIncomplete();
    }

    public function testGetRootUrl()
    {
        $container = $this->mockContainer();
        $container->set('translator', new IdentityTranslator());
//        $router = new Router();
//        $router->setContext(new RequestContext('https://example.org'));
//        $container->set('router', $router);

        $listener = new NewsPostedListener($container);

        $this->assertSame('https://example.org', $listener->getRootUrl());
    }
}
