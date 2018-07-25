<?php

return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../../../common/config/test-local.php'),
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