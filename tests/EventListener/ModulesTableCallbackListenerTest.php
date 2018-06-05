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


use Contao\Model\Collection;
use Contao\ModuleModel;
use Contao\TestCase\ContaoTestCase;
use HeimrichHannot\ContaoNewsAlertBundle\EventListener\ModulesTableCallbackListener;

class ModulesTableCallbackListenerTest extends ContaoTestCase
{
    public function getFrameworkMock()
    {
        $moduleModelMock = $this->mockAdapter(['findByType']);
        $moduleModelMock->method('findByType')->willReturnOnConsecutiveCalls(
            new Collection($this->createModuleModels(), 'tl_module'),
            null);

        $framework = $this->mockContaoFramework([
            ModuleModel::class => $moduleModelMock,
        ]);
        return $framework;

    }

    public function testCanBeInstantiated()
    {
        $module = new ModulesTableCallbackListener($this->getFrameworkMock());
        $this->assertInstanceOf(ModulesTableCallbackListener::class, $module);
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
        $listener = new ModulesTableCallbackListener($this->getFrameworkMock());

        $this->assertEquals(3, count($listener->getNewsalertModules()));
        $this->assertEmpty($listener->getNewsalertModules());


    }
}