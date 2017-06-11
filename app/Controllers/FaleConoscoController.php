<?php

namespace App\Controllers;


use App\Models\DavisYearly;
use App\Models\FaleConosco;
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

        $success = 0;
        try{
            $this->db->persist($novaMensagem);
            $this->db->flush();
            $success = 1;
        }catch (Exception $e){
            $success = 0;
        }
        return $this->view->render($response, "faleConosco.html.twig", ['message'=>($success == 1 ? 'Success' : 'Fail')]);
    }

    public function listNaoLidasCount(Request $request, Response $response, array $args){
        $qb = $this->db->getRepository(FaleConosco::class);
        $qb = $qb->findByLida(false);
        echo count($qb);
    }

    public function listarMensagens(Request $request, Response $response, array $args){
        $mensagens = $this->db->getRepository(FaleConosco::class)->findByIsArquivado(false);
        return $this->view->render($response, "visualizarTodasMensagens.html.twig", ["mensagens"=>$mensagens]);
    }

    public function visualizarMensagem(Request $request, Response $response, array $args){
        $msg = $this->db->find(FaleConosco::class, $request->getParsedBody()['msgId']);
        $msg->setLida(true);

        $this->db->persist($msg);
        $this->db->flush($msg);

        return $this->view->render($response, "lerMensagem.html.twig", ["msg"=>$msg]);

    }
    public function arquivarMensagem(Request $request, Response $response, array $args){
        $msg = $this->db->find(FaleConosco::class, $request->getParsedBody()['msgId']);
        $msg->setIsArquivado(true);

        $this->db->persist($msg);
        $this->db->flush($msg);

        $mensagens = $this->db->getRepository(FaleConosco::class)->findByIsArquivado(false);
        return $this->view->render($response, "visualizarTodasMensagens.html.twig",['message'=>'success',"mensagens"=>$mensagens]);

    }

    public function mensagensArquivadas(Request $request, Response $response, array $args){
        $mensagens = $this->db->getRepository(FaleConosco::class)->findByIsArquivado(true);
        return $this->view->render($response, "visualizarTodasMensagens.html.twig", ["mensagens"=>$mensagens]);
    }
}