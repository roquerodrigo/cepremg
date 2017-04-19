<?php

namespace App\Controllers;

use App\Models\Davis;
use DateTime;
use Exception;
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
        ini_set('max_execution_time', 300);

        $files = $request->getUploadedFiles();

        foreach ($files['davis'] as $file) {
            try {
                if (!$this->container->db->isOpen()) {
                    $this->container->db = $this->container->db->create(
                        $this->container->db->getConnection(),
                        $this->container->db->getConfiguration()
                    );
                }

                $lines = explode("\n", $file->getStream());

                // Ignora as duas primeiras linhas (cabecalho da tabela) e a última (em branco).
                $length = count($lines) - 1;
                for ($i = 2; $i < $length; $i++) {
                    $data = explode("\t", $lines[$i]);

                    $dateTime = DateTime::createFromFormat('d/m/y H:i', $data[0] . ' ' . $data[1]);

                    if ($dateTime instanceof DateTime) {
                        $davis = new Davis();

                        $davis->setDateTime($dateTime)
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
                    } else {
                        throw new Exception('Erro na linha ' . ($i + 1));
                    }

                }

                $this->container->db->flush();

            } catch (Exception $e) {
                $caught = true;
                $messages[] = [
                    'message' => "Erro no arquivo " . $file->getClientFilename() . ":\n" . $e->getMessage() . "\n",
                    'type'    => 'danger',
                ];
            } finally {
                if (empty($caught)) {
                    $messages[] = [
                        'message' => "Arquivo " . $file->getClientFilename() . " inserido com sucesso.",
                        'type'    => 'success',
                    ];
                }
            }
        }

        return $this->view->render($response, 'import.html.twig', [
            'messages' => $messages,
        ]);
    }
}