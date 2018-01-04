<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\ContaoNewsAlertBundle\Test\Backend;


use HeimrichHannot\ContaoNewsAlertBundle\Backend\Modules;
use PHPUnit\Framework\TestCase;

class ModulesTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $module = new Modules();
        $this->assertInstanceOf(Modules::class, $module);
    }
}