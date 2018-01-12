<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\ContaoNewsAlertBundle\Tests\Backend;


use Contao\Model\Collection;
use Contao\ModuleModel;
use Contao\System;
use Contao\TestCase\ContaoTestCase;
use HeimrichHannot\ContaoNewsAlertBundle\Backend\Modules;

class ModulesTest extends ContaoTestCase
{
    public function testCanBeInstantiated()
    {
        $module = new Modules();
        $this->assertInstanceOf(Modules::class, $module);
    }

    public function createModuleModels()
    {
        $data = [
            0 => 'Test00Module',
            2 => 'Test02Module',
            '7' => 'TestString7Module'
        ];
        $models = [];
        foreach ($data as $key=>$value)
        {
            $model = $this->getMockBuilder(ModuleModel::class)
                ->disableOriginalConstructor()
                ->setMethods(['_get','_set'])
                ->getMock();
//            $model = $this->createMock(ModuleModel::class);
//            $model
//            $model->arrData = ['id' => $key, 'name' => $value];
            $model->id = $key;
            $model->name = $value;
            $models[] = $model;
        }
        return $models;
    }

    public function testGetNewsalertModules()
    {
        $adapter = $this->mockAdapter(['findByType']);
        $adapter->method('findByType')->willReturn(new Collection($this->createModuleModels(), 'tl_module'));

        $framework = $this->mockContaoFramework([ModuleModel::class => $adapter]);
        $container = $this->mockContainer();
        $container->set('contao.framework', $framework);
        System::setContainer($container);

        $this->assertEquals(3, count(Modules::getNewsalertModules()));


    }
}