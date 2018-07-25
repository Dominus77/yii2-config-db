<?php
defined('YII_APP_BASE_PATH') || define('YII_APP_BASE_PATH', __DIR__ . '/../../../../');
return yii\helpers\ArrayHelper::merge(
    require(YII_APP_BASE_PATH . '/common/config/test-local.php'),
    [
        'id' => 'module-config',
        'language' => 'en',
        'components' => [
            'request' => [
                'csrfParam' => '_csrf-frontend-test',
                'enableCsrfValidation' => false,
            ],
        ],
    ]
);