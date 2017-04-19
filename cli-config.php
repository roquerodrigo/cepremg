<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;

require_once __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/app/config.php';

$doctrineConfig = Setup::createAnnotationMetadataConfiguration([__DIR__ . '/app/models'], $config['isDevMode']);

$entityManager = EntityManager::create($config['database'], $doctrineConfig);

return ConsoleRunner::createHelperSet($entityManager);
