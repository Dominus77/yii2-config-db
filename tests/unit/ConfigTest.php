<?php

namespace modules\config\tests\unit;

use Yii;
use modules\config\models\Config;
use modules\config\params\ConfigParams;

/**
 * Class ConfigTest
 * @package modules\config\tests\unit
 */
class ConfigTest extends \Codeception\Test\Unit
{
    /**
     * This get default value
     */
    public function testGetDefaultValue()
    {
        $model = new Config([
            'param' => 'TEST_NAME',
            'label' => 'Test Name',
            'value' => '',
            'type' => ConfigParams::FIELD_TYPE_STRING,
            'default' => 'Tester',
        ]);
        $this->assertTrue($model->save());

        $app = Yii::$app;
        $config = $app->config;
        $name = $config->get('TEST_NAME');
        $this->assertEquals($name, 'Tester');
    }

    /**
     * This get value
     */
    public function testGetValue()
    {
        $model = new Config([
            'param' => 'TEST_NAME',
            'label' => 'Test Name',
            'value' => 'Ym Tester',
            'type' => ConfigParams::FIELD_TYPE_STRING,
            'default' => 'Tester',
        ]);
        $this->assertTrue($model->save());

        $app = Yii::$app;
        $config = $app->config;
        $name = $config->get('TEST_NAME');
        $this->assertEquals($name, 'Ym Tester');
    }

    /**
     * This set value
     */
    public function testSetValue()
    {
        $model = new Config([
            'param' => 'TEST_NAME',
            'label' => 'Test Name',
            'value' => '',
            'type' => ConfigParams::FIELD_TYPE_STRING,
            'default' => 'Tester',
        ]);
        $this->assertTrue($model->save());

        $app = Yii::$app;
        $config = $app->config;
        $name = $config->get('TEST_NAME');
        $this->assertEquals($name, 'Tester');

        $config->set('TEST_NAME', 'Ym Tester');
        $name = $config->get('TEST_NAME');
        $this->assertEquals($name, 'Ym Tester');
    }
}
