<?php

namespace modules\config\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use dominus77\sweetalert2\Alert;
use yii\filters\AccessControl;
use modules\config\models\Config;
use modules\rbac\models\Permission;
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
                    'roles' => [Permission::PERMISSION_MANAGER_CONFIG]
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
            Yii::$app->session->setFlash(Alert::TYPE_SUCCESS, [
                [
                    'title' => Module::t('module', 'Saving settings'),
                    'text' => Module::t('module', 'Settings successfully saved.'),
                    'timer' => 3000,
                ]
            ]);
        }

        return $this->render('update', [
            'model' => $settings,
        ]);
    }
}
