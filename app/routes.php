<?php

use App\Controllers\DataController;
use App\Controllers\ImportController;

$app->get('/', DataController::class . ':index');
$app->get('/get-data/type/{type}/start/{start}/end/{end}', DataController::class . ':getData');
$app->get('/import', ImportController::class . ':showForm');
$app->post('/import', ImportController::class . ':import');
