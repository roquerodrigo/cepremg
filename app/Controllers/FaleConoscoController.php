<?php
/**
 * Created by PhpStorm.
 * User: lfaria
 * Date: 10/06/17
 * Time: 22:29
 */

namespace App\Controllers;


use app\Models\FaleConosco;
use Exception;
use Slim\Http\Request;
use Slim\Http\Response;

class FaleConoscoController extends Controller {

    public function index(Request $request, Response $response, array $args) {
        return $this->view->render($response, "faleConosco.html.twig");
    }
    public function criaMensagem(Request $request, Response $response, array $args){
        $postParams = $request->getParsedBody();

        $novaMensagem = new FaleConosco();
        $novaMensagem->setFinalidade($postParams["finalidade"])->setInstituicao($postParams["instituicao"])->setNome($postParams["nome"])->setPeriodo($postParams["periodo"]);

        $succes = 0;
        try{
            $this->db->persist($novaMensagem);
            $this->db->flush();
            $succes = 1;
        }catch (Exception $e){
            $succes = 0;
        }
        return $this->view->render($response, "faleConosco.html.twig", [($succes == 0 ? "Sucess" : "Fail") => 0]);
    }
}