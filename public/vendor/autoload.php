<?php
/**
 * Created by PhpStorm.
 * User: KEVEN
 * Date: 08/07/2020
 * Time: 19:47
 */

spl_autoload_register(function ($className) {
    $filePath = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    require_once($filePath . '.class.php');
});
