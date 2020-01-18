<?php

$router = new \Phalcon\Mvc\Router();

$router->addPost(
    '/',
    [
        'action' => 'index'
    ]
);

$router->addPost(
    '/getFromAssign',
    [
        'action' => 'getFromAssign'
    ]
);

return $router;
