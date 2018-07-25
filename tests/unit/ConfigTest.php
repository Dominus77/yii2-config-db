<?php

namespace modules\config\tests\unit;

use Yii;
use yii\base\InvalidConfigException;
use modules\config\models\Config;
use modules\config\params\ConfigParams;

/**
 * Class ConfigTest
 * @package modules\config\tests\unit
 */
class ConfigTest extends \Codeception\Test\Unit
{
    /**
     * @var \modules\config\tests\UnitTester
     */
    protected $tester;

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
     * This get not params
     */
    public function testGetValueNotParam()
    {
        $this->tester->expectException(new InvalidConfigException('Undefined parameter NONE_PARAM'), function () {
            $this->getNotParam();
        });
    }

    /**
     * @return InvalidConfigException
     */
    protected function getNotParam()
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
        return $config->get('NONE_PARAM');
    }

    /**
     * This set value success
     */
    public function testSetValueSuccess()
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
