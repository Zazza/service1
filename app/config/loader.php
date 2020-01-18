<?php

$loader = new \Phalcon\Loader();

$loader
    ->registerNamespaces([
        'Controllers' => $config->application->controllersDir,
        'App' => $config->application->SrcDir
    ])
    ->register();

require $config->application->vendorDir . 'autoload.php';
