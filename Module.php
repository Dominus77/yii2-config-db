<?php

namespace modules\config;

use Yii;
use yii\console\Application as ConsoleApplication;

/**
 * Class Module
 * @package modules\config
 */
class Module extends \yii\base\Module
{
    /**
     * Class Params extends \modules\config\models\ConfigParams
     * @var string
     */
    public $paramsClass = 'modules\config\models\Params';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'modules\config\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (empty($this->params['paramsClass'])) {
            $this->params['paramsClass'] = $this->paramsClass;
        }

        if (Yii::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'modules\config\console';
        }
    }

    /**
     * @param string $category
     * @param string $message
     * @param array $params
     * @param null|string $language
     * @return string
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/config/' . $category, $message, $params, $language);
    }
}
