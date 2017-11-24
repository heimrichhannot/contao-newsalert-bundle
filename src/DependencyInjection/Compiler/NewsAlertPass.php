<?php

/*
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0+
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class NewsAlertPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('hh.contao-newsalert.newstopiccollection')) {
            return;
        }
        $definition = $container->findDefinition('hh.contao-newsalert.newstopiccollection');
        $taggedServices = $container->findTaggedServiceIds('hh.newsalert.topic_source');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addTopicSource', [new Reference($id)]);
        }
    }
}
