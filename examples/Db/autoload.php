<?php
$rootDir = dirname(__DIR__, 2);
require $rootDir . '/vendor/autoload.php';

spl_autoload_register(function($class) {
    $baseDir = dirname(__DIR__, 2) . '/src';
    $offset = strlen('Haoa\\Mixdb\\');
    $path = substr($class, $offset, strlen($class));
    $path = $baseDir . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $path) . '.php';
    require($path);
});