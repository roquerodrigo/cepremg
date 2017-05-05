<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;

require_once __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/app/config.php';

if (is_file(__DIR__ . '/app/config-overwrite.php')) {
    $developmentConfig = require __DIR__ . '/app/config-overwrite.php';
    $config = array_merge($config, $developmentConfig);
}

$doctrineConfig = Setup::createAnnotationMetadataConfiguration([__DIR__ . '/app/Models'], $config['isDevMode']);

$entityManager = EntityManager::create($config['database'], $doctrineConfig);

return ConsoleRunner::createHelperSet($entityManager);
