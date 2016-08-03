<?php

namespace gambit\banner\rotator\item;

/**
 * Description of DbRotate
 * @var gambit\banner\rotator\AbstractRotate $vendor
 * @author gambit
 */
class DbRotate extends \gambit\banner\rotator\ComposeRotate
{

    /**
     * @var self
     */
    private static $_instance = null;
    public $vendor;
    public $model;

    /**
     * singleton 
     */
    public function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = (new self());
        }
        return self::$_instance;
    }

    public function initObject($vendor)
    {
        $this->vendor = $vendor;
        $this->db = \Yii::$app->get($this->vendor->componentDb);
    }

    private function __construct()
    {
        
    }

    public function getItems()
    {
        $this->vendor->items = $this->model->find()->where(['title' => $this->vendor->name])->all();
    }
}
