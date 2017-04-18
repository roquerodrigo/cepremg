<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__ . '/app/boostrap.php';

return ConsoleRunner::createHelperSet($entityManager);
