<?php

namespace App\Controllers;

use App\Models\Davis;
use DateTime;
use Doctrine\ORM\Query\ResultSetMapping;
use Exception;
use Slim\Http\Request;
use Slim\Http\Response;

class ImportController extends Controller
{
    public function showForm(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'import.html.twig');
    }

    public function import(Request $request, Response $response, array $args)
    {
        ini_set('max_execution_time', 300);

        $files = $request->getUploadedFiles();

        foreach ($files['davis'] as $file) {
            try {
                if (!$this->db->isOpen()) {
                    $this->db = $this->db->create(
                        $this->db->getConnection(),
                        $this->db->getConfiguration()
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

                        $this->db->persist($davis);
                    } else {
                        throw new Exception('Erro na linha ' . ($i + 1));
                    }
                }

                $this->db->flush();

            } catch (Exception $e) {
                $caught = true;
                $messages[] = [
                    'message' => 'Erro no arquivo ' . $file->getClientFilename() . ":\n" . $e->getMessage() . "\n",
                    'type'    => 'danger',
                ];
            } finally {
                if (empty($caught)) {
                    $messages[] = [
                        'message' => 'Arquivo ' . $file->getClientFilename() . ' inserido com sucesso.',
                        'type'    => 'success',
                    ];
                }
            }
        }

        try {
            $this->db->createNativeQuery('CALL atualiza_tabelas()', new ResultSetMapping())->getResult();
        } catch (Exception $e) {
        }

        return $this->view->render($response, 'import.html.twig', [
            'messages' => $messages,
        ]);
    }
}
