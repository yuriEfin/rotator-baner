<?php

namespace gambit\banner\rotator\item;

/**
 * Description of FileRotate
 *
 * @author gambit
 */
class FileRotate extends \gambit\banner\rotator\ComposeRotate
{

    /**
     * @var object gambit\banner\rotator\AbstractRotate
     */
    public $vendor;

    /**
     * singleton
     */
    public function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct()
    {
        
    }

    public function initObject($vendor)
    {
        $this->vendor = $vendor;
    }

    public function getItems()
    {
        $filename = $this->vendor->pathStorage;
        if (!file_exists($filename) !== false) {
            $this->vendor->items = \yii\helpers\Json::decode(file_get_contents(\Yii::getAlias($filename)));
        }
    }
}
