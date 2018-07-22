<?php

namespace modules\config\components\behaviors;

use Yii;
use yii\base\Behavior;
use yii\web\Controller;

/**
 * Class DelcacheBehavior
 * @package modules\config\components\behaviors
 */
class DelcacheBehavior extends Behavior
{
    /**
     * id кэша (названия в виде массива)
     * @var array
     */
    public $cache_id = [];

    /**
     * для каких действий контроллера
     * @var array
     */
    public $actions = [];

    /**
     * @return array
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'deleteCache',
        ];
    }

    /**
     * Удаление массива кэшированных элементов (виджеты, модели...)
     */
    public function deleteCache()
    {
        $action_name = $this->owner->action->id;
        if (array_search($action_name, $this->actions) === false) return;

        foreach ($this->cache_id as $id) {
            Yii::$app->cache->delete($id);
        }
    }
}
