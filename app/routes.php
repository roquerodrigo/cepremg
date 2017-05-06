<?php

use App\Controllers\DataController;
use App\Controllers\ImportController;
use App\Controllers\UserController;

$app->get('/', DataController::class . ':index');
$app->get('/get-data/type/{type}/time-period/{timePeriod}/start/{start}/end/{end}', DataController::class . ':getData');

$app->get('/login', UserController::class . ':loginForm');
$app->post('/login', UserController::class . ':login');

/***********************************************
 * Middleware: islogedIn
 *
 * Verifica se o usuário está logado no sistema
 * independende do seu nível de privilégio.
 */

$isLogedIn = function ($request, $response, $next) {
 	if($_SESSION['auth']!==true){
 		return $response->withStatus(401)->withHeader('Location', '/login');		
 	}
    $response = $next($request, $response);
    return $response;
};

/***********************************************
 * Middleware: isRoot
 *
 * Verifica se o usuário logado no sistema
 * tem privilégio de nível ROOT.
 */

$isRoot = function($request,$response,$next) {
	if($_SESSION['privilege'] !== 0) {
		return $response->withStatus(401)->withHeader('Location', '/');
	}
	$response = $next($request, $response);
    return $response;
};

/***********************************************
 * Routes: /import
 *
 * Necessitam de login no sistema independente
 * do nível de privilégio.
 */

$app->group('/import', function(){

	$this->get('', ImportController::class . ':showForm');
	$this->post('', ImportController::class . ':import');

})->add($isLogedIn);

/***********************************************
 * Routes: /user
 *
 * Necessitam de login no sistema independente
 * do nível de privilégio.
 */

$app->group('/user', function(){

	$this->get('', UserController::class . ':index');
	$this->get('/myaccount', UserController::class . ':updateForm');

	$this->post('/myaccount', UserController::class . ':update');

})->add($isLogedIn);

/***********************************************
 * Routes: /admin
 *
 * Necessitam de login no sistema e privilégio
 * ROOT.
 */

$app->group('/admin',function(){

	$this->get('/register', UserController::class . ':createForm');
	$this->get('/disable',UserController::class.':deleteForm');

	$this->post('/register', UserController::class . ':create');
	$this->post('/disable',UserController::class.':delete');

})->add($isLogedIn)->add($isRoot);;

$app->get('/logout', UserController::class . ':logout')->add($isLogedIn);
