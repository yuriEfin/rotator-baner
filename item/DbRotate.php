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
     * @param type $this
     * @param DbRotate $this
     */
    public function getInstance($this)
    {
        if (!self::$_instance) {
            self::$_instance = new self($this);
        }
    }

    private function __construct($vendor)
    {
        $this->vendor = $vendor;
        $this->model = $this->vendor->getModel();
    }

    public function getItems()
    {
        $this->vendor->items = $this->model->find()->where(['title' => $this->vendor->name])->all();
    }
}
