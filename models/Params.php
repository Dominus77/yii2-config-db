<?php

namespace modules\config\models;

/**
 * Class Params
 * @package modules\config\models
 */
class Params extends ConfigParams
{
    /**
     * Global params to site
     * @return array
     */
    public static function findParams()
    {
        return [
            [
                'param' => 'SITE_NAME',
                'label' => 'Site Name',
                'value' => '',
                'type' => self::FIELD_TYPE_STRING,
                'default' => 'My Site',
            ],
            [
                'param' => 'SITE_TIME_ZONE',
                'label' => 'Timezone',
                'value' => '',
                'type' => self::FIELD_TYPE_STRING,
                'default' => 'Europe/Moscow',
            ],
            [
                'param' => 'SITE_LANGUAGE',
                'label' => 'Language',
                'value' => '',
                'type' => self::FIELD_TYPE_STRING,
                'default' => 'ru',
            ]
        ];
    }
}
