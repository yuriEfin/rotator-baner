<?php

/**
 * BannerRotator - the class for show and accounting mediabanners on view pages.
 *
 * @package yii-rotator
 * @author  Roman V <tvitcom@yandex.ru>
 * @link https://github.com/tvitcom/yii-rotator
 * @license GNU GENERAL PUBLIC LICENSE Version 2
 */
class BannerRotator extends CApplicationComponent
{
    public static $tplDir = 'assets';
    public static $arrTplExtensions = array('.html', '.js');

    public function init()
    {
        parent::init();
    }

    public static function findWithoutExtension($path = '', $name = '')
    {
        foreach (self::$arrTplExtensions as $extension) {
            $filelocation = $path . $name . $extension;
            if (file_exists($filelocation))
                return $filelocation;
        }
        return false;
    }

    // Sample:              display('banner_ok', '10%')
    public static function display($id = '', $metric = '0%')
    {
        // Find file for id as filename in template directory:
        $path = __DIR__ . '/' . self::$tplDir . '/';
        $filelocation = self::findWithoutExtension($path, $id);

        // Вычисляем количество для вывода:
        $residual = RBanner::residual($id);
        if (self::typeMetric($metric) === 'percent') {
            $count = $residual * intval($metric) * 0.01;
        } elseif (intval($metric) < $residual) {
            $count = $residual - intval($metric);
        } else {
            $count = $residual;
        }

        //Next line for debug purposes:
        if (0) {
            echo '<br>Всего:' . $residual;
            echo '<br>Отнять:' . $count;
            echo '<br>Вывести:' . ceil($count);
            echo '<br>typeMetric:' . self::typeMetric($metric);
            echo '<br>Путь:' . $filelocation;
        }

        // Если файл шаблона найден и количество имеется в БД то:
        if ($filelocation && ceil($count)) {

            //Отнимаем в счетчике показа баннера в БД:
            RBanner::decrementDisplay($id, ceil($count));
            self::overallShow($residual, $filelocation, $count);
        } else {
            echo '<div class="flash-error">banner balance is exhausted!!!</div>';
        }
    }

    public static function overallShow($residual, $filelocation, $count)
    {
        if ($residual) {
            for ($i = 0; $i < ceil($count); $i++) {
                echo '<div class="flash-success">';
                $opendata = fopen($filelocation, "rb");
                fpassthru($opendata);
                fclose($opendata);
                echo '</div>';
            }
        }
    }

    public static function typeMetric($value = '')
    {
        $value = strpbrk($value, '%');
        if ($value)
            return 'percent';
        else
            return 'integer';
    }
}
