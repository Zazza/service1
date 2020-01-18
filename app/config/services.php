<?php

use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;

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

$di->setShared('view', function () use ($config) {
    $view = new View();
    $view
        ->setViewsDir($config->application->viewsDir)
        ->setLayoutsDir($config->application->viewsDir)
        ->setPartialsDir($config->application->viewsDir);
    $view->registerEngines(array(
        '.volt' => function ($view, $di) use ($config) {
            $volt = new Phalcon\Mvc\View\Engine\Volt($view, $di);
            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_',
                'compileAlways' => true
            ));

            return $volt;
        },
    ));
    $view->setRenderLevel(View::LEVEL_ACTION_VIEW);

    return $view;
});