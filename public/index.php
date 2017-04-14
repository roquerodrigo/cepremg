<?php

use Slim\App;
use Slim\Views\Twig;

require __DIR__ . '/../vendor/autoload.php';

$app = new App([
    'settings' => require __DIR__ . '/../app/config.php'
]);

$app->getContainer()['view'] = function ($container) {
    return new Twig(__DIR__ . '/../views');
};

require __DIR__ . '/../app/routes.php';

$app->run();
