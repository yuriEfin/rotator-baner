<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace gambit\banner\rotator;

/**
 * Description of Rotator
 *
 * @author gambit
 */
class Rotator
{

    const TYPE_RANGE_PERCENT = '%';
    const TYPE_RANGE_INTEGER = 'int';

    /**
     * Ошибка превышение лимита показов
     */
    const ERROR_LIMIT = 100;

    /**
     * @var object ShowBanner
     */
    public $vendor;

    /**
     * Тип ротации % или Integer
     * @var type 
     */
    public $type;
    public $isError = false;
    public $errorCode;

    /**
     * описание ошибок
     * @var type 
     */
    public $errors = [
        self::ERROR_LIMIT => 'Превышение лимита показов',
    ];

    /**
     * @var object self 
     */
    private static $_instance;

    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    protected function getLogFile()
    {
        return $this->vendor->logPath . '/' . $this->vendor->name . '.json';
    }

    /**
     * храним последнее значение Количества показов
     */
    public function log()
    {
        $filename = \Yii::getAlias($this->getLogFile());

        $data = [];
        $data[$this->vendor->name]['value'] = $this->getValue();
        if (file_exists($filename)) {
            $data = \yii\helpers\Json::decode(file_get_contents($filename));
            $newValue = $value = $this->getValue();
            // если есть какие-то данные по имени баннера
            // пишем остаточное значение количества баннеров
            if (isset($data[$this->vendor->name], $data[$this->vendor->name]['value'])) {
                $count = $newValue + $data[$this->vendor->name]['value'];
                // если полученная новая сумма не превышает значения default у выбарнного баннера
                if ($this->isAllovedShow($count)) {
                    $value = $count;
                }
            }
            // новое значение
            $data[$this->vendor->name]['value'] = $value;
        }
        // фиксируем состояние
        file_put_contents($filename, json_encode($data));
    }

    public function init(ShowBanner $vendor)
    {
        $this->vendor = $vendor;

        $this->setTypeRange();


        // возвращаем самого себя (цепочка вызовов)
        return $this;
    }

    public function isAllovedShow($count)
    {
        return $this->vendor->default >= $count;
    }

    public function getCountDisplay()
    {
        $countValue = $this->getValue();
        if (!$this->isAllovedShow($countValue)) {
            $this->isError = true;
            return $this->errorCode = self::ERROR_LIMIT;
        }
        return $countValue;
    }

    /**
     * @return type
     */
    public function getValue($type = null)
    {
        if (!$type) {
            $type = $this->type;
        }

        $count = $this->vendor->count;

        if ($type == self::TYPE_RANGE_PERCENT) {
            $count = ceil(($this->vendor->default * $this->vendor->count) / 100);
        }
        return $count;
    }

    /**
     * тип значения количества баннеров
     */
    private function setTypeRange()
    {
        // default
        $this->type = self::TYPE_RANGE_INTEGER; // число
        // проверка если %
        if (stripos($this->vendor->count, self::TYPE_RANGE_PERCENT) !== FALSE) {
            $this->type = self::TYPE_RANGE_PERCENT; // %
        }
    }
}
