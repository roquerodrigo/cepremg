<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/', function (Request $request, Response $response) {
    return $this->view->render($response, 'index.html.twig');
});

$app->get('/import', \App\Controllers\ImportController::class . ':showForm');
$app->post('/import', \App\Controllers\ImportController::class . ':import');
