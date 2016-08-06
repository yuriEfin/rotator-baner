Ротатор баннеров
================
Task description:

Требуется написать систему вывода рекламы. Класс, либо расширение для Yii

Имеется множество шаблонов html/js

Возьмем для примера superbanner.php с текстом:

<a id="banner-id-54447" href="/копеечка_в_копилку.html" target="_blank">

<div>Кликни меня</div>

</a>

Требования к приложению:

- Приложение должно уметь подключать подобные шаблоны без указания типа файла, а только его имени, т.е "superbanner" ( возвращается код файла )

- Возможность задавать количество возвращаемых кодов ( подключаю "superbanner" 3 раза и т.д )

- Должен быть конфиг приложения для возможности задать кол-во возвращаемых кодов по умолчанию

- Возможность задавать процентное отображение количества кодов. Например в конфиге для баннера "superbanner" указано по умолчанию 50 шт. Вызывая приложение мы сообщаем что нам нужно 50% от указанного количества в конфиге и нам возвращается 25 кодов. При этом запоминается для этого типа остаточное число баннеров. Забрали 25. Осталось 25. При следующем запросе в % или кол-ве приложение уже будет расчитывать из остатка кодов. Т.е вызов на странице что то типа

echo Banners::get("superbanner", '50%') // вернулось 25 кодов

// вызываем второй раз на странице

echo Banners::get("superbanner", '20%') // вернулось 5 кодов и еще осталось 20

======================
Вывод баннеров с учетом ограничения по количеству

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yii2-gambit/yii2-banner "*"
```

or add

```
"yii2-gambit/yii2-banner": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php

$config = [
    'superbanner' => [
        'default' => 10,
        'banner' => [
            'file' => '@app/web/img/banners/superbanner/superbanner_1.php',
            'id' => '54447',
            'url' => 'http://yandex.ru',
        ],
    ],
    'superbanner2' => [
        'default' => 5,
        'banner' => [
            'file' => '@app/web/img/banners/superbanner2/superbanner2_1.js',
            'id' => '54454',
            'url' => 'http://wordstat.yandex.ru',
        ],
    ],
    'superbanner3' => [
        'default' => 50,
        'banner' => [
            'file' => '@app/web/img/banners/superbanner3/superbanner.html',
            'id' => '54461',
            'url' => 'http://wordstat.yandex.ru',
        ],
    ],
];

<?=               
        \gambit\banner\rotator\ShowBanner::widget([
            'name' => 'superbanner',
            'config' => \Yii::getAlias('@frontend') . '/config/banners.php',
            'count' => '5%',
            'default' => '50',
        ]); 
?>```

file log example record 
{"superbanner":{"value":5}}
{"superbanner2":{"value":12}}

```php

    Переопределяемые свойства 

    /**
     * Наименование группы баннеров
     */
    public $name;

    /**
     * Переопределение значения опции 'default' в конфигурационном файле баннеров
     * @var integer
     */
    public $default;

    /**
     * Structure elements 
     *      [
     *           'file' => '@app/web/img/banners/superbanner/superbanner_1.php',
     *           'url' => 'http://yandex.ru',
     *           'id' => '54447',
     *      ],
     * @var array
     */
    public $banner;

    /**
     * Путь к конфигу
     * @var string
     */
    public $configPath = '@app/config/banners.php';

    /**
     * @var конфигурация баннеров
     */
    public $config = [];

    /**
     * @var integer
     */
    public $count = 0;

    /**
     * Рассчитанное ротатором кол-во
     * @var integer 
     */
    public $counterRotate;
    public $logPath = '@app/runtime/';

    /**
     * class path rotator
     */
    public $classPathRotator = '\gambit\banner\rotator\Rotator';

    /**
     * @var object Rotator
     */
    public $rotate = null;

    /**
     * Html attributes 
     * @var array
     */
    public $option = [];

    /**
     * Баннеры
     * @var array
     */
    public $items = [];

    /**
     * наименование view (шаблона)
     * @var array
     */
    public $viewName = 'show_banner';

```