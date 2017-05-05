<?php

use App\Controllers\DataController;
use App\Controllers\ImportController;
use App\Controllers\UserController;

$app->get('/', DataController::class . ':index');
$app->get('/get-data/type/{type}/time-period/{timePeriod}/start/{start}/end/{end}', DataController::class . ':getData');

$app->get('/login', UserController::class . ':loginForm');
$app->post('/login', UserController::class . ':login');

/*
 * Rotas que precisam de Controle de Acesso
 * e CRUD de usuário.
 */


$isLogedIn = function ($request, $response, $next) {
 	if($_SESSION['auth']!==true){
 		die(header('Location: /login')); 		
 	}
    $response = $next($request, $response);
    return $response;
};

$app->group('/import', function(){

	$this->get('', ImportController::class . ':showForm');
	$this->post('', ImportController::class . ':import');

})->add($isLogedIn);

$app->group('/user', function(){

	$this->get('', UserController::class . ':index');
	$this->get('/register',UserController::class . ':createForm');
	$this->post('/register',UserController::class . ':create');
	$this->get('/myaccount', UserController::class . ':updateForm');
	$this->post('/myaccount', UserController::class . ':update');

})->add($isLogedIn);

$app->get('/logout', UserController::class . ':logout')->add($isLogedIn);
