<?php

namespace pastuhov\querytag\tests\unit;

use yii\codeception\TestCase;
use yii\console\Application;

class UnitTestCase extends TestCase
{
    protected function _before()
    {
        $this->mockApplication($this->getAppConfig());
    }

    protected function getAppConfig()
    {
        $config = require __DIR__ . '/../app/config/console.php';
        $config['class'] = Application::class;

        return $config;
    }
}
