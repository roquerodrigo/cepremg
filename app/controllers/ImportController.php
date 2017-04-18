<?php

namespace App\Controllers;

use App\Models\Davis;
use DateTime;
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

        // Ignora as duas primeiras linhas (cabecalho da tabela) e a última (em branco).
        $length = count($lines) - 1;
        for ($i = 2; $i < $length; $i++) {
            $data = explode("\t", $lines[$i]);

            $davis = new Davis();

            $davis->setDateTime(
                DateTime::createFromFormat('d/m/y H:i', $data[0] . ' ' . $data[1])
            )
                ->setTempOut($data[2])
                ->setHiTemp($data[3])
                ->setLowTemp($data[4])
                ->setOutHum($data[5])
                ->setDewPt($data[6])
                ->setWindSpeed($data[7])
                ->setWindDir($data[8])
                ->setBar($data[16])
                ->setRain($data[17])
                ->setSolarRad($data[19])
                ->setUVIndex($data[22]);

            $this->container->db->persist($davis);
        }
        $this->container->db->flush();
    }
}