<?php

/*
 * Copyright (c) 2022 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0+
 */

namespace HeimrichHannot\ContaoNewsAlertBundle;

use HeimrichHannot\ContaoNewsAlertBundle\DependencyInjection\Compiler\NewsAlertPass;
use HeimrichHannot\ContaoNewsAlertBundle\DependencyInjection\HeimrichHannotContaoNewsAlertExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HeimrichHannotContaoNewsAlertBundle extends Bundle
{
    /**
     * Builds the bundle.
     *
     * It is only ever called once when the cache is empty.
     *
     * This method can be overridden to register compilation passes,
     * other extensions, ...
     *
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new NewsAlertPass());
    }

    public function getContainerExtension()
    {
        return new HeimrichHannotContaoNewsAlertExtension();
    }
}
