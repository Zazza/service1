<?php

$router = new \Phalcon\Mvc\Router();

$router->addPost(
    '/',
    [
        'action' => 'index'
    ]
);

return $router;
