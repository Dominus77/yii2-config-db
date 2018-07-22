# yii2-config-db

Модуль для хранения, вывода и редактирования настроек приложения Yii2 в базе данных.

### Установка
Выполнить в корне приложения
```
git clone https://github.com/Dominus77/yii2-config-db.git modules/config
```
Применить миграцию
```
php yii migrate/up -p=modules\config\migrations

```

### Подключение для advanced
Подключаем компонент модуля в common части, что бы компонент был доступен во всём приложении
```
// common\config\main.php

$config = [
    //...
    'components' => [
        'config' => [
            'class' => 'modules\config\components\DConfig',
            'duration' => 3600, // Время для кэширования   
        ],
        // Определяем место для кэша
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@frontend/runtime/cache',
        ],
        //...
    ],
    //...
];
```
Подключаем модуль в backend части для возможности изменять значения в админке
```
// backend\config\main.php

$config = [
    'bootstrap' => [
        //...
        'modules\config\Bootstrap',
    ],
    'modules' => [
        'config' => [
            'class' => 'modules\config\Module',
        ],
        //...
    ],
    // Подключаем поведение для применения наших параметров
    'as afterConfig' => [
        'class' => '\modules\config\components\behaviors\ConfigBehavior',
    ],
    //...    
];

```
Подключаем модуль в console части для консольных команд
```
// console\config\main.php

$config = [
    'bootstrap' => [
        //...
        'modules\config\Bootstrap',
    ],
    'modules' => [
        'config' => [
            'class' => 'modules\config\Module',
        ],
        //...
    ], 
    //...       
];

```
В frontend части подключаем только поведение для применения наших параметров
```
// frontend\config\main.php

$config = [    
    // Подключаем поведение для применения наших параметров
    'as afterConfig' => [
        'class' => '\modules\config\components\behaviors\ConfigBehavior',
    ],
    //...    
];

```
Подключение закончено.
### Настройка

Далее следует задать параметры которые будем хранить и изменять.

Все параметры задаются в классе [[modules\config\models\Params]]. Данный класс наследуется от 
[[modules\config\models\ConfigParams]] который реализует интерфейс [[modules\config\components\interfaces\ConfigInterface]].

Пример класса Params
```
<?php

namespace backend\models;

use Yii;
use modules\config\models\ConfigParams;

class Params extends ConfigParams
{
    /**
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
```
Что бы подключить данный класс следует указать его в конфигурации при подключении модуля.
Если не указывать свой класс, то параметры будут браться из класса модуля [[modules\config\models\Params]].
```
$config = [
    //...
    'modules' => [
        'config' => [
            'class' => 'modules\config\Module',
            'params' => [
                'paramsClass' => 'backend\models\Params'
            ],
        ],
        //...
    ], 
    //...       
];

```

### Компонент
Задаём значение параметру:
```
\Yii::$app->config->set('SITE_NAME', 'Мой сайт');
```
Получаем значение параметра:
```
\Yii::$app->config->get('SITE_NAME');
```
Удаляем значение параметра:
```
\Yii::$app->config->delete('SITE_NAME');
```
### Поведение
В поведении [[\modules\config\components\behaviors\ConfigBehavior]] автоматически присваиваются наши значения тем что прописаны в конфигурации,
поэтому если требуется изменить какое либо значение из конфигурации нашим, то необходимо так же прописать его и в поведении.
В текущем исполнении заданы базовые параметры, такие как name, language, timeZone.
Для добавления своих параметров можно создать своё поведение и подключить его вместо [[\modules\config\components\behaviors\ConfigBehavior]].

Для того что бы не писать всё время присваивание значений в поведении, можно поступить следующим образом,
в класс Params, в котором мы задаём параметры, добавить метод getReplace()
```
<?php

namespace backend\models;

use Yii;
use modules\config\models\ConfigParams;

class Params extends ConfigParams
{
    /**
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
            ],
            [
                'param' => 'ADMIN_EMAIL',
                'label' => 'Email administrator',
                'value' => '',
                'type' => self::FIELD_TYPE_STRING,
                'default' => 'admin@example.loc',
            ],
            [
                'param' => 'SUPPORT_EMAIL',
                'label' => 'Email support',
                'value' => '',
                'type' => self::FIELD_TYPE_STRING,
                'default' => 'support@example.loc',
            ],
        ];
    }
    
    /**
     * Ассоциируем ключи конфига с нашими параметрами для замены
     * @return array
     */
    public static function getReplace()
    {
        return [
            'name' => 'SITE_NAME',
            'timeZone' => 'SITE_TIME_ZONE',
            'language' => 'SITE_LANGUAGE',
            'adminEmail' => 'ADMIN_EMAIL',
            'supportEmail' => 'SUPPORT_EMAIL',
        ];
    }
}

```
и модифицировать наше поведение следующим образом:
```
<?php

namespace common\components\behaviors;

use Yii;
use yii\base\Behavior;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\web\Application;
use backend\models\Params;

/**
 * Class ConfigBehavior
 * @package common\components\behaviors
 */
class ConfigBehavior extends Behavior
{
    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'setConfig'
        ];
    }

    /**
     * Set config
     */
    public function setConfig()
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
        $replace = Params::getReplace();
        foreach ($replace as $key => $value) {
            if (isset($app->{$key}))
                $app->{$key} = ArrayHelper::getValue($array, $value);
            if (isset($app->params[$key])) {
                $app->params[$key] = ArrayHelper::getValue($array, $value);
            }
        }
    }
}

```
Теперь параметры и ассоциации можно определять только в одном классе Params, всё остальное выполнит наше поведение.

### Консольные команды
Для заполнения базы данных установленными параметрами
```
php yii config/init/up
```
Для удаления данных
```
php yii config/init/down
```
### Ссылка на редактирование в backend
```
<?= \yii\helpers\Url::to(['/config/default/update']) ?>
```
### Свой вид
Для изменения вида формы редактирования идущей в комплекте с модулем, можно воспользоваться темизацией.

Настроим компонент view приложения для темизации
```
// backend\config\main.php

$current_theme = 'default'; // тема
$config = [
    //...
    'components' => [            
        'view' => [
            'theme' => [
                'basePath' => '@app/themes/' . $current_theme,
                'baseUrl' => '@app/themes/' . $current_theme,
                'pathMap' => [
                    '@app/views' => '@app/themes/' . $current_theme . '/views',
                    '@modules' => '@app/themes/' . $current_theme . '/modules',
                ],
            ],
        ],
        //...
     ],
    //...       
];

```
В backend части создаём папки и два файла со следующей структурой.
```
\backend
    themes
        default
            modules
                config
                    views
                        default
                            _form.php
                            update.php

```
Файлы можно скопировать из модуля и изменить по своему желанию.

После проделаных манипуляций, файлы вида модуля теперь будут браться из установленной нами темы, default.

## Лицензия
The MIT License (MIT). Please see [License File](https://github.com/Dominus77/yii2-config-db/blob/master/LICENSE.md) for more information.
