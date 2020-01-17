<?php

use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Mvc\Dispatcher;

$di->setShared('config', $config);

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $url = new UrlResolver();
    $url->setBaseUri('/');

    return $url;
});

$di->set(
    'router',
    function () {
        require __DIR__ . '/router.php';

        return $router;
    }
);

$di->set('dispatcher', function () use ($di) {
    $eventsManager = $di->getShared('eventsManager');

    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('Controllers');
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
});

$di->set(
    "view",
    function () {
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir("../apps/views/");
        return $view;
    }
);

