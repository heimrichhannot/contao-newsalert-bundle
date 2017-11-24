<?php

/*
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0+
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\Test\ContaoManager;

use HeimrichHannot\ContaoNewsAlertBundle\ContaoManager\Plugin;
use PHPUnit\Framework\TestCase;

/**
 * Contao Open Source CMS.
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */
class PluginTest extends TestCase
{
    public function testInstantiation()
    {
        static::assertInstanceOf(
            \HeimrichHannot\ContaoNewsAlertBundle\ContaoManager\Plugin::class,
            new Plugin()
        );
    }
}
