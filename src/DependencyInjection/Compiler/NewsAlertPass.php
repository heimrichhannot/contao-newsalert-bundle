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
        if (!$container->has('huh.newsalert.topiccollection')) {
            return;
        }
        $definition = $container->findDefinition('huh.newsalert.topiccollection');
        
        $taggedServices = $container->findTaggedServiceIds('huh.newsalert.topic_source');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addTopicSource', [new Reference($id)]);
        }

        $taggedServices = $container->findTaggedServiceIds('hh.newsalert.topic_source');

        if (count($taggedServices) > 0)
        {
            trigger_error("Tag hh.newsalert.topic_source has beed marked deprecated and will be removed in next major newsalert version. Use huh.newsalert.topiccollection instead.", E_USER_NOTICE);
        }

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addTopicSource', [new Reference($id)]);
        }
    }
}
