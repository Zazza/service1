<?php
use Phalcon\DI;
use Phalcon\DI\FactoryDefault;

$di = new FactoryDefault();

$config = include __DIR__ . "/../app/config/config.php";
require __DIR__ . '/../app/config/services.php';
include __DIR__ . '/../app/config/loader.php';

$loader->registerDirs(
    array(
        __DIR__
    )
);
$loader->register();
