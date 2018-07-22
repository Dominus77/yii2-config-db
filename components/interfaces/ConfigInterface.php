<?php

namespace modules\config\components\interfaces;

/**
 * Interface ConfigInterface
 *
 * class ConfigParams implements ConfigInterface
 * {
 *      public static function findDefaultParams()
 *      {
 *          return [
 *              [
 *                   'param' => 'SITE_NAME',
 *                   'label' => 'Site Name',
 *                   'value' => '',
 *                   'type' => 'string',
 *                   'default' => 'My Site',
 *               ],
 *              // etc.
 *          ];
 *      }
 * }
 *
 * @package modules\config\components\interfaces
 */
interface ConfigInterface
{
    /**
     * Return config params array
     * @return array
     */
    public static function findParams();
}
