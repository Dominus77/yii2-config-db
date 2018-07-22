<?php

namespace modules\config\console;

use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use console\components\helpers\Console;
use modules\config\traits\ModuleTrait;
use yii\base\InvalidConfigException;
use modules\config\Module;

/**
 * Class InitController
 * @package modules\config\console
 */
class InitController extends Controller
{
    use ModuleTrait;

    /** @var \modules\config\models\ConfigParams $params */
    protected $params;

    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws InvalidConfigException
     */
    public function beforeAction($action)
    {
        if (empty($this->getModule()->params['paramsClass'])) {
            throw new InvalidConfigException(Module::t('module', 'You must specify the Params class in the module settings.'));
        }
        $this->params = $this->getModule()->params['paramsClass'];
        return parent::beforeAction($action);
    }

    /**
     * All Commands
     * @inheritdoc
     */
    public function actionIndex()
    {
        echo 'yii config/init/up' . PHP_EOL;
        echo 'yii config/init/down' . PHP_EOL;
    }

    /**
     * Loading data config into the in database
     * @inheritdoc
     */
    public function actionUp()
    {
        Yii::$app->config->add($this->params::findParams());
        echo $this->log(true);
    }

    /**
     * Remove data config from the in database
     */
    public function actionDown()
    {
        $params = ArrayHelper::getColumn($this->params::findParams() , 'param');
        Yii::$app->config->delete($params);
        echo $this->log(true);
    }

    /**
     * @param bool|int $success
     */
    private function log($success = false)
    {
        if ($success === true || $success !== 0) {
            $this->stdout(Console::convertEncoding(Module::t('module', 'Success!')), Console::FG_GREEN, Console::BOLD);
        } else {
            $this->stderr(Console::convertEncoding(Module::t('module', 'Error!')), Console::FG_RED, Console::BOLD);
        }
        echo PHP_EOL;
    }
}
