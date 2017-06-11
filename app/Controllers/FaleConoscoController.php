<?php
/**
 * Created by PhpStorm.
 * User: lfaria
 * Date: 10/06/17
 * Time: 22:29
 */

namespace App\Controllers;


use Slim\Http\Request;
use Slim\Http\Response;

class FaleConoscoController extends Controller {

    public function index(Request $request, Response $response, array $args) {
        return $this->view->render($response, "faleConosco.html.twig");
    }
    public function criaMensagem(Request $request, Response $response, array $args){
        $postParams = $request->getParsedBody();
        return $postParams["periodo"];
    }
}