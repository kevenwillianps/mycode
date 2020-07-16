<?php
/**
 * Created by PhpStorm.
 * user: KEVEN
 * Date: 18/07/2019
 * Time: 13:26
 */

/** Defino o local onde a classes esta localizada **/
namespace vendor\model;

class ArrayUtf8Encode
{
    public function utf8Converter($array)
    {
        array_walk_recursive($array, function (&$item, $key) {
            if (!mb_detect_encoding($item, 'utf-8', true)) {
                $item = utf8_encode($item);
            }
        });

        return $array;
    }
}
