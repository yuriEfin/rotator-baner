<?php

namespace gambit\banner\rotator;

use yii;
use gambit\banner\rotator\item\DbRotate;
use gambit\banner\rotator\item\FileRotate;

/**
 * Description of AbstractRotate
 *
 * @author gambit
 */
abstract class AbstractRotate extends \yii\base\Widget
{

    /**
     * Типы хранения баннеров
     */
    const TYPE_DB = 'db';
    const TYPE_FILE = 'file';

    /**
     * Наименование баннера = тип баннера
     * @var string
     */
    public $name;

    /**
     * наименование модели баннеров - работа с базой
     * например: '\app\models\Banner'
     * @var string
     */
    public $modelRotate;

    /**
     * Инстанс конкретной реализации ротатора - файл или база или, например, Curl запрос на сторонний ресурс по API или еще как-то
     * @var \gambit\banner\rotator\ComposeRotate 
     */
    public $rotateInstance = null;

    /**
     * Типы возможных реализаций
     * Можно отнаследоваться и расширить типы в своей реализации
     * @var array 
     */
    public static $typesRotate = [
        'db', 'file'
    ];

    /**
     * Типы баннеров 
     * html,js
     * @var array
     */
    public $types = [
        'html', 'js'
    ];

    /**
     * Алиасы типов баннеров 
     * При необходимости можно добавить сопоставления типам - что и как интерпретировать
     * html,js
     */
    public $typesAlias = [
        'html' => 'html',
        'js' => 'js',
        'php' => 'html',
    ];

    /**
     *
     * @var yii\db\Connection
     */
    public $db;

    /**
     * Компонент соединения с базой
     * Default 'db'
     * @var type 
     */
    public $componentDb = 'db';

    /**
     * тип ротации 
     * Откуда берем баннеры - в базе или в файле
     * Варианты 'db' или 'file'
     * Default 'db'
     * @var string
     */
    public $typeRotate = 'db';

    /**
     * Если выбран тип хранения баннеров - в файле 
     * путь к файлу
     * @var string 
     */
    public $pathStorage = '@rotate-banner/assets/banner-list.json';

    /**
     * Путь к директории с баннерами
     * @var string
     */
    public $pathDir = '@rotate-banner/assets';

    /**
     * запрошенные баннеры
     * @var array
     */
    public $items = [];

    public function init()
    {
        parent::init();
        if (!isset(\Yii::$aliases['@rotate-banner'])) {
            \Yii::setAlias('@rotate-banner', dirname(__FILE__) . '/assets');
        }
        $this->db = \Yii::$app->get($this->componentDb);
    }

    public function setInstance()
    {
        if (!$this->typeRotate) {
            throw new \yii\base\InvalidConfigException('Property {typeRotate} can not be empty');
        }
        switch ($this->typeRotate) {
            case self::TYPE_DB:
                $this->rotateInstance = DbRotate::getInstance()->initObject($this);
                break;
            case self::TYPE_FILE:
                $this->rotateInstance = FileRotate::getInstance()->initObject($this);
                ;
                break;
        }
    }

    /**
     * @return yii\db\ActiveRecord
     */
    protected function getModel()
    {
        $class = $this->modelRotate;
        if (!class_exists($class)) {
            throw new \yii\base\ErrorException('class modelRotate - {' . $class . '} not found');
        }
        return new $class();
    }

    /**
     * Тип баннера Js или Html
     * Можно использовать для других реализаций - например задать тип баннера 'url' 
     * и реализовать Curl получение баннера со стороннего источника
     * TODO: не используется пока
     */
    public function getType()
    {
        $path_info = pathinfo($filename);
        if (!isset($this->types[$path_info['extension']])) {
            throw new \yii\base\InvalidParamException('Transferred to unauthorized type of banner {' . $path_info['extension'] . '}');
        }
        return $this->typesAlias[$path_info['extension']];
    }

    /**
     * Рендеринг отдельного баннера
     * Логика отображения
     */
    abstract public function renderItem($item);

    /**
     * Рендеринг баннеров
     * Логика отображения
     */
    abstract public function renderItems();
}
