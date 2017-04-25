<?php

use App\Controllers\DataController;
use App\Controllers\ImportController;
use App\controllers\UserController;

$app->get('/', DataController::class . ':index');
$app->get('/get-data/type/{type}/start/{start}/end/{end}', DataController::class . ':getData');
$app->get('/import', ImportController::class . ':showForm');
$app->post('/import', ImportController::class . ':import');

/**
 * Rotas para Controle de Acesso
 */

$app->get('/login', UserController::class . ':showForm');
$app->post('/login', UserController::class . ':login');
$app->get('/logout',UserController::class.':logout');