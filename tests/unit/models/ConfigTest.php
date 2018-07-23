<?php

namespace modules\config\tests\unit\models;

use modules\config\models\Config;

/**
 * Class ConfigTest
 * @package modules\config\tests\unit\models
 */
class ConfigTest extends \Codeception\Test\Unit
{
    /**
     * Example test
     */
    public function testExample()
    {
        $model = new Config();
        $this->assertArrayHasKey('CachedBehavior', $model->behaviors());
    }
}
