<?php
/**
 * Application configuration shared by all applications and test types
 */
$config = [
    'id' => 'app-test',
    'basePath' => dirname(__DIR__),
    'runtimePath' => dirname(dirname(__DIR__)) . '/_output',
    'bootstrap' => ['log'],
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'sqlite:' . dirname(dirname(__DIR__)) . '/_output/sqlite_test.db',
            'charset' => 'utf8',
            'commandClass' => \pastuhov\querytag\tests\app\components\Command::class,
            'enableSlaves' => true,
            'slaves' => [
                'one' => [
                    'dsn' => 'sqlite:' . dirname(dirname(__DIR__)) . '/_output/sqlite_test_slave.db',
                ]
            ],
            'slaveConfig' => [
                'class' => \yii\db\Connection::class,
                'commandClass' => \pastuhov\querytag\tests\app\components\SlaveCommand::class,
            ],
        ],
        'log' => [
            'flushInterval' => 1,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    //'categories' => ['yii\db'],
                    'logVars' => [],
                    'levels' => ['info'],
                    'exportInterval' => 1,
                ],
            ],
        ],
    ],
];

if (YII_ENV_TEST) {
    // configuration adjustments for 'test' environment
    $config['bootstrap'][] = 'logstock';
    $config['modules']['logstock'] = [
        'class' => \pastuhov\logstock\Module::class,
        'fixturePath' => codecept_data_dir() . 'logstock',
    ];

}

return $config;

