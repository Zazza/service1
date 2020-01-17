<?php

$loader = new \Phalcon\Loader();

$loader
    ->registerNamespaces([
        'Controllers' => $config->application->controllersDir,
        'Service' => $config->application->srcDir
    ])
    ->register();

require $config->application->vendorDir . 'autoload.php';
