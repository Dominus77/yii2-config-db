<?php

namespace modules\config\components\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\Controller;
use yii\helpers\ArrayHelper;
use yii\web\Application;

/**
 * Class ConfigAdvancedBehavior
 * @package modules\config\components\behaviors
 */
class ConfigAdvancedBehavior extends Behavior
{
    /**
     * @var \modules\config\params\Params
     */
    public $paramsClass = '\modules\config\params\Params';

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction'
        ];
    }

    /**
     * Set config
     */
    public function beforeAction()
    {
        /** @var Application $app */
        $app = $this->owner;
        $this->setParams($app);
    }

    /**
     * Set params
     * @param Application $app
     */
    private function setParams(Application $app)
    {
        $array = Yii::$app->config->getAll();
        $replace = $this->paramsClass::getReplace();
        foreach ($replace as $key => $value) {
            if (isset($app->{$key})) {
                if ($key == 'language' && YII_ENV_TEST) {
                    $app->{$key} = $app->language;
                } else {
                    $app->{$key} = ArrayHelper::getValue($array, $value);
                }
            }
            if (isset($app->params[$key])) {
                $app->params[$key] = ArrayHelper::getValue($array, $value);
            }
        }
    }
}
