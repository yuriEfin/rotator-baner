<?php

namespace gambit\banner\rotator;

class Helper
{

    /**
     * Расширение файла
     * @param string $filename
     * @return string
     */
    public static function getType($filename)
    {
        $path_info = pathinfo($filename);
        return $path_info['extension'];
    }
}
