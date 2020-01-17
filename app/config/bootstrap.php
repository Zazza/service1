<?php

use Phalcon\Mvc\Application;
use Phalcon\Config\Adapter\Ini as ConfigIni;

require_once realpath(dirname(dirname(__FILE__))) . '/config/env.php';

$config = include __DIR__ . "/config.php";
$configS = new ConfigIni(__DIR__ . "/config.test.ini");
$config->merge($configS);

$di = new \Phalcon\Di\FactoryDefault();

require_once  __DIR__ . '/loader.php';
require  __DIR__ . '/services.php';

$application = new Application($di);

return $application;