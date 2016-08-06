Ротатор баннеров
================
Вывод баннеров в случайном порядке Yii, MySQL

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