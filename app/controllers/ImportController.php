<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class ImportController extends Controller
{

    public function showForm(Request $request, Response $response, Array $args)
    {
        return $this->view->render($response, 'import.html.twig');
    }

    public function import(Request $request, Response $response, Array $args)
    {
        $files = $request->getUploadedFiles();
        $lines = explode("\n", $files['davis']->getStream());

        $data = [];
        // Ignora as duas primeiras linhas (cabecalho da tabela) e a última (em branco).
        $length = count($lines) - 1;
        for ($i = 2; $i < $length; $i++) {
            $data[] = explode("\t", $lines[$i]);
        }

        print_r($data);

    }
}