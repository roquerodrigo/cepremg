<?php

use App\Controllers\AdminController;
use App\Controllers\DataController;
use App\Controllers\FaleConoscoController;
use App\Controllers\ImportController;
use App\Controllers\UserController;

$app->get('/', DataController::class . ':index');
$app->get('/get-data/type/{type}/time-period/{timePeriod}/start/{start}/end/{end}', DataController::class . ':getData');

$app->get('/login', UserController::class . ':loginForm');
$app->post('/login', UserController::class . ':login');

$app->get('/faleConosco', FaleConoscoController::class . ':index');
$app->post('/faleConosco/enviarMensagem', FaleConoscoController::class . ':criaMensagem');
$app->post('/faleConosco/countMsg', FaleConoscoController::class . ':listNaoLidasCount');

/***********************************************
 * Middleware: islogedIn
 *
 * Verifica se o usuário está logado no sistema
 * independende do seu nível de privilégio.
 */

$isLogedIn = function ($request, $response, $next) {
    if (empty($_SESSION['auth'])) {
        return $response->withStatus(401)->withHeader('Location', '/login');
    }

    return $next($request, $response);
};

/***********************************************
 * Middleware: isRoot
 *
 * Verifica se o usuário logado no sistema
 * tem privilégio de nível ROOT.
 */

$isRoot = function ($request, $response, $next) {
    if ($_SESSION['privilege'] !== 0) {
        return $response->withStatus(401)->withHeader('Location', '/');
    }

    return $next($request, $response);
};

/***********************************************
 * Routes: /import
 *
 * Necessitam de login no sistema independente
 * do nível de privilégio.
 */

$app->group('/import', function () {
    $this->get('', ImportController::class . ':showForm');
    $this->post('', ImportController::class . ':import');
}); //->add($isLogedIn);

/***********************************************
 * Routes: /user
 *
 * Necessitam de login no sistema independente
 * do nível de privilégio.
 */

$app->group('/user', function () {
    $this->get('', UserController::class . ':index');
    $this->get('/myaccount', UserController::class . ':updateForm');

    $this->post('/myaccount', UserController::class . ':update');
})->add($isLogedIn);

$app->get('/logout', UserController::class . ':logout')->add($isLogedIn);

/***********************************************
 * Routes: /admin
 *
 * Necessitam de login no sistema e privilégio
 * ROOT.
 */

$app->group('/admin', function () {
    $this->get('/register-user[/{message}]', AdminController::class . ':createForm');
    $this->get('/disable-user', AdminController::class . ':deleteForm');

    $this->post('/register-user', AdminController::class . ':create');
    $this->post('/disable-user', AdminController::class . ':delete');

    $this->get('/mensagens', FaleConoscoController::class . ':listarMensagens');
    $this->post('/mensagens/visualizarMsg', FaleConoscoController::class . ':visualizarMensagem');
    $this->post('/mensagens/arquivar', FaleConoscoController::class . ':arquivarMensagem');
    $this->get('/mensagens/countNaoLidas', FaleConoscoController::class . ':listNaoLidasCount');
    $this->get('/mensagens/arquivadas', FaleConoscoController::class . ':mensagensArquivadas');


    $this->get('/dataOverview',\App\Controllers\OverviewController::class.':index');
    $this->get('/dataOverview/hourly',\App\Controllers\OverviewController::class.':getOverview');
    $this->get('/dataOverview/daily',\App\Controllers\OverviewController::class.':getOverview');
    $this->get('/dataOverview/monthly',\App\Controllers\OverviewController::class.':getOverview');
    $this->get('/dataOverview/yearly',\App\Controllers\OverviewController::class.':getOverview');
    $this->post('/dataOverview/verMais',\App\Controllers\OverviewController::class.':verMais');

});//->add($isLogedIn)->add($isRoot);
