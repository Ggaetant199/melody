<?php
$timeRequestBegin = microtime();

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__DIR__));
define('ROOT_ROOT', dirname(dirname(__DIR__)));
define('HOST', $_SERVER['HTTP_HOST']);
define('BOOT', "/melody/test");

include ROOT_ROOT . DS . 'vendor' . DS . 'autoload.php';

function uri ($uri) {
    return BOOT . $uri;
}