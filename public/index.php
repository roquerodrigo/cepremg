<?php

use Slim\App;
use Slim\Views\Twig;

require __DIR__ . '/../app/boostrap.php';

$app = new App([
    'settings' => $config,
]);

$app->getContainer()['view'] = function ($container) {
    return new Twig(__DIR__ . '/../resources/views');
};

require __DIR__ . '/../app/routes.php';

$app->run();
