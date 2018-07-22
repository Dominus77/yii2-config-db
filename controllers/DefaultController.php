<?php

namespace modules\config\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\filters\AccessControl;
use modules\config\models\Config;
// use modules\rbac\models\Permission;
use modules\config\Module;

/**
 * Class DefaultController
 * @package modules\config\controllers
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => $this->getAccess()
        ];
    }

    /**
     * @return array
     */
    private function getAccess()
    {
        return [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'] // Permission::PERMISSION_MANAGER_CONFIG
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionUpdate()
    {
        $settings = Config::find()->indexBy('id')->all();
        if (Model::loadMultiple($settings, Yii::$app->request->post()) && Model::validateMultiple($settings)) {
            foreach ($settings as $setting) {
                $setting->save(false);
            }
            Yii::$app->session->setFlash('success', Module::t('module', 'Settings successfully saved.'));
        }

        return $this->render('update', [
            'model' => $settings,
        ]);
    }
}
