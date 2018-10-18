<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0+
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\Tests;

use HeimrichHannot\ContaoNewsAlertBundle\DependencyInjection\HeimrichHannotContaoNewsAlertExtension;
use HeimrichHannot\ContaoNewsAlertBundle\HeimrichHannotContaoNewsAlertBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class HeimrichHannotContaoNewsAlertBundleTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $bundle = new HeimrichHannotContaoNewsAlertBundle();
        $this->assertInstanceOf(HeimrichHannotContaoNewsAlertBundle::class, $bundle);
    }

    public function testGetContainerExtension()
    {
        $bundle = new HeimrichHannotContaoNewsAlertBundle();
        $this->assertInstanceOf(
            HeimrichHannotContaoNewsAlertExtension::class,
            $bundle->getContainerExtension()
        );
    }

//    public function testBuild()
//    {
//        $container = new ContainerBuilder();
//        $container->setParameter('kernel.root_dir', __DIR__.'/app');
//        $bundle = new HeimrichHannotContaoNewsAlertBundle();
//        $bundle->build($container);
//        $classes = [];
//        foreach ($container->getCompilerPassConfig()->getPasses() as $pass) {
//            var_dump($pass);
//            $reflection = new \ReflectionClass($pass);
//            $classes[] = $reflection->getName();
//            echo $reflection->getName();
//        }
//        $this->assertContains(HeimrichHannotContaoNewsAlertExtension::class, $classes);
//    }
}
