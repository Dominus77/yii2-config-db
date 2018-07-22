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
Подключаем компонент модуля в common части, что бы компонент был доступен везде
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
Подклюяаем модуль в backend части для возможности изменять значения в админке
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
    // Подключаем поведение для применения наших настроек
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
В frontend части подключаем только поведение для применения наших настроек
```
// frontend\config\main.php

$config = [    
    // Подключаем поведение для применения наших настроек
    'as afterConfig' => [
        'class' => '\modules\config\components\behaviors\ConfigBehavior',
    ],
    //...    
];

```
Подключение закончено.
### Настройка

Далее следует задать настройки которые будем хранить и изменять.

Все настройки находятся в классе [[modules\config\models\Params]]. Данный класс наследуется от 
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
Если не указывать свой класс, то настройки будут браться из класса модуля [[modules\config\modelsParams]].
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
Задаём значение:
```
\Yii::$app->config->set('SITE_NAME', 'Мой сайт');
```
Получаем значение:
```
\Yii::$app->config->get('SITE_NAME');
```
Удаляем значение:
```
\Yii::$app->config->delete('SITE_NAME');
```
### Поведение
В поведении [[\modules\config\components\behaviors\ConfigBehavior]] автоматически присваиваются наши значения тем что прописаны в конфигурации,
поэтому если требуется изменить какое либо значение из конфигурации нашим, то необходимо так же прописать его и в поведении.
В текущем исполнении заданы базовые настройки такие как name, language, timeZone.
Для добавления своих параметров можно создать своё поведение, отнаследовавшись от [[\modules\config\components\behaviors\ConfigBehavior]].

### Консольные команды
Для заполнения базы данных установленными настройками
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
