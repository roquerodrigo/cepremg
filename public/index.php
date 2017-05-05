<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Slim\App;
use Slim\Views\Twig;

date_default_timezone_set('UTC');

require __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../app/config.php';

if (is_file(__DIR__ . '/../app/config-overwrite.php')) {
    $developmentConfig = require __DIR__ . '/../app/config-overwrite.php';
    $config = array_merge($config, $developmentConfig);
}

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

/* Setting _SESSION global for twig*/
if (!session_id()) {
    session_start();
    $app->getContainer()['view']['session'] = $_SESSION;
}

require __DIR__ . '/../app/routes.php';



$app->run();
