<?php

namespace gambit\banner\rotator;

/**
 * This is just an example.
 */
class ShowBanner extends \yii\base\Widget
{

    const TYP_HTML = 'html';
    const TYP_HTM = 'htm';
    const TYP_JS = 'js';
    const TYP_PHP = 'php';

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

    public function init()
    {
        parent::init();
        // подключаем конифгурационный файл баннеров
        if (!$this->configPath) { // если путь к конфигу не задан
            $this->config = require \Yii::getAlias($this->getDefaultConfigPath());
        } else {
            $this->config = require \Yii::getAlias($this->configPath);
        }
        // инициализация свойств 'banner' и 'default' и иных
        // таким образом через конфиг можно проинициализировать все свойства виджета
        foreach ($this->config[$this->name] as $property => $value) {
            if (property_exists(__CLASS__, $property)) {
                $this->{$property} = $value;
            }
        }
        $this->getRotate();
        // получаем количество раз - которое нужно показать в текущем вызове Виджета
        $this->counterRotate = $this->rotate->getCountDisplay();
    }

    public function getDefaultConfigPath()
    {
        return '@app/config/banners.php';
    }

    /**
     * Получаем объект ротатора 
     * Реализация переопределяется через свойство this 'classPathRotator' 
     * Объект создается посредством singleton pattern чтобы запоминать сосотояние в одном объекте ну и не плодить сами объекты
     */
    public function getRotate()
    {
        $classRotator = $this->classPathRotator;
        $this->rotate = $classRotator::getInstance()
            ->init($this); // init rotator
    }

    public function run()
    {
        $classRotator = $this->classPathRotator;
        if ($this->count !== $classRotator::ERROR_LIMIT) {
            // непосредственно перед рендером фиксируем новое значение
            $this->rotate->log();
            return $this->render($this->viewName, ['count' => $this->counterRotate, 'banner' => $this->banner]);
        } else {
            return '<!-- HAPPY END {' . $this->name . '} -->';
        }
    }
}
