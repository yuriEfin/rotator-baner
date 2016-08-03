<?php

namespace gambit\banner\rotator;

use yii;

/**
 * Description of ComposeRotate
 *
 * @author gambit
 */
class ComposeRotate extends \yii\base\Widget implements ICompositInterface
{

    /**
     * требуемое кол-во
     * @var mixed integer | string 
     */
    public $count;

    /**
     * Счетчик
     * @var type 
     */
    public $qty;

    public function getItems()
    {
        return [];
    }

    public static function typeCount()
    {
        return stripos($this->count, '%') !== FALSE ? 'percent' : 'integer';
    }
}
