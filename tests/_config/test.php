<?php
return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../../../common/config/test-local.php'),
    require(__DIR__ . '/../../../../frontend/config/main.php'),
    require(__DIR__ . '/../../../../frontend/config/main-local.php'),
    [
        'id' => 'app-frontend-tests',
        'language'=>'en',
        'components' => [
            'request' => [
                'csrfParam' => '_csrf-frontend-test',
                'enableCsrfValidation' => false,
            ],
        ],
    ]
);
