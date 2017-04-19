<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Slim\App;
use Slim\Views\Twig;

require __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../app/config.php';

$app = new App([
    'settings' => $config,
]);

$app->getContainer()['view'] = function ($container) {
    return new Twig(__DIR__ . '/../resources/views');
};

$app->getContainer()['db'] = function ($container) {
    $doctrineConfig = Setup::createAnnotationMetadataConfiguration([__DIR__ . '/models'], $container->get('settings')['isDevMode']);

    return EntityManager::create($container->get('settings')['database'], $doctrineConfig);
};

require __DIR__ . '/../app/routes.php';

$app->run();
