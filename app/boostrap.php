<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once __DIR__ . "/../vendor/autoload.php";

$config = require "config.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$doctrineConfig = Setup::createAnnotationMetadataConfiguration([__DIR__ . "/models"], $config['isDevMode']);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

// obtaining the entity manager
$entityManager = EntityManager::create($config['database'], $doctrineConfig);
