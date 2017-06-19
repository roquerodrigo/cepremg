<?php

namespace App\Controllers;

use App\Models\Davis;
use App\Models\DavisDaily;
use App\Models\DavisHourly;
use App\Models\DavisMonthly;
use App\Models\DavisYearly;
use DateTime;
use Doctrine\DBAL\Exception\DriverException;
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

        $convert = $request->getParam('convert');
        $overwrite = $request->getParam('overwrite');

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

                /*
                 * Apagar as 2 primeiras linhas por serem cabeçalhos e a
                 * última por estar sempre vazia. Durante a varredura
                 * do arquivo as linhas que ja tiverem os valores extraídos
                 * serão removidas para economia de memória. As instâncias do
                 * model davis após persistidas, serão clonadas para um array,
                 * futuramente usado para geração de models DavisHourly, DavisDaily,
                 * DavisMonnthly e DavisYearly.
                 */
                unset($lines[0]);
                unset($lines[1]);

                $lines = array_values($lines);
                $length = count($lines) - 1;
                unset($lines[$length]);

                $davisArray = [];
                foreach ($lines as $i => $line) {
                    $data = explode("\t", $line);
                    $dateTime = DateTime::createFromFormat('d/m/y H:i', $data[0] . ' ' . $data[1]);
                    /**
                     * A aplicação não ira usar todos dados presentes no arquivo,
                     * os dados utilizados serão:
                     * 1) Data e Hora
                     * 2) Temperatura Média
                     * 3) Maior Temperatura
                     * 4) Menor Temperatura
                     * 5) Umidade do Ar
                     * 6) Temperatura do ponto de orvalho
                     * 7) Direção do vento
                     * 8) Pressão atmosférica
                     * 9) Chuva
                     * 10) Radiação Solar
                     * 11) Indice Ultra violeta
                     * 12) Velocidade do Vento
                     * Estão sendo atribuidos na mesma ordem.
                     */
                    $filter = function ($x) {
                        //USAR REGEX
                        if ($x[0] == '-') {
                            return;
                        }

                        return $x;
                    };

                    if ($dateTime instanceof DateTime) {
                        $davis = new Davis();
                        $davis->setDateTime($dateTime)
                            ->setTempOut($filter($data[2]))
                            ->setHiTemp($filter($data[3]))
                            ->setLowTemp($filter($data[4]))
                            ->setOutHum($filter($data[5]))
                            ->setDewPt($filter($data[6]))
                            ->setWindDir($filter($data[8]))
                            ->setBar($filter($data[16]))
                            ->setRain($filter($data[17]))
                            ->setSolarRad($filter($data[19]))
                            ->setUVIndex($filter($data[22]));

                        if ($convert) {
                            $davis->setWindSpeed($data[7] / 3.6);
                        } else {
                            $davis->setWindSpeed($data[7]);
                        }

                        unset($lines[$i]);
                        $davisArray[] = clone $davis;
                    } else {
                        throw new Exception('Erro na linha ' . ($i + 4));
                    }
                }

                $davisHourlyArray = $this->generateDavis__($davisArray, DavisHourly::class);
                $davisDailyArray = $this->generateDavis__($davisHourlyArray, DavisDaily::class);
                $davisMonthlyArray = $this->generateDavis__($davisDailyArray, DavisMonthly::class);
                $davisYearlyArray = $this->generateDavis__($davisMonthlyArray, DavisYearly::class);

                /*
                 * Agora que as instâncias já estão prontas os valores
                 * serão preparados e persistidos no SGBD.
                 */

                foreach ($davisArray as $instance) {
                    $this->db->persist($instance);
                }
                foreach ($davisHourlyArray as $instance) {
                    $this->db->persist($instance->doPrepare());
                }
                foreach ($davisDailyArray as $instance) {
                    $this->db->persist($instance->doPrepare());
                }
                foreach ($davisMonthlyArray as $instance) {
                    $this->db->persist($instance->doPrepare());
                }
                foreach ($davisYearlyArray as $instance) {
                    $this->db->persist($instance->doPrepare());
                }

                $this->db->flush();
            } catch (Exception $e) {
                if ($e instanceof DriverException) {
                    $errorCode = $e->getErrorCode();
                    if ($errorCode === 1062 && $overwrite == 1) { //DUPLICATA
                        $caught = true;
                        $messages[] = [
                            'message' => 'Erro no arquivo ' . $file->getClientFilename() . ":\nO arquivo possui uma entrada já existente no Banco.\n" . $e->getMessage(),
                            'type'    => 'danger',
                        ];
                    } elseif ($errorCode === 1265) { //TRUNCATE
                        $caught = true;
                        $messages[] = [
                            'message' => 'Erro no arquivo ' . $file->getClientFilename() . ":\nO arquivo possui valores com tipos errados.\n" . $e->getMessage(),
                            'type'    => 'danger',
                        ];
                    }
                } else {
                    $caught = true;
                    $messages[] = [
                        'message' => 'Erro no arquivo ' . $file->getClientFilename() . ":\n" . $e->getMessage() . "\n",
                        'type'    => 'danger',
                    ];
                }
            } finally {
                if (empty($caught)) {
                    $messages[] = [
                        'message' => 'Arquivo ' . $file->getClientFilename() . ' inserido com sucesso.',
                        'type'    => 'success',
                    ];
                }
            }
        }

        return $this->view->render($response, 'import.html.twig', [
            'messages' => $messages,
        ]);
    }

    /**
     * @param array  $davisArray as intâncias irão variar de acordo com a chamada
     * @param string $repoClass  classe a ser criada nos objetos do array retornado
     *
     * @return array $newDavisArray
     */
    private function generateDavis__(&$davisArray, $repoClass)
    {
        $newDavisArray = [];
        $newDavisObject = null;
        $repository = $this->db->getRepository($repoClass);

        foreach ($davisArray as $i => $davis) {
            $time = new $repoClass($davis);
            $time = $time->getDateTime();
            /*
             * Checando se a posição do vetor contém algum valor,
             * caso tenha mesclar os valores de $davis, caso
             * contrário procurar um registro no banco de $repoClass.
             * Se encontrado sera usado como base, mesclando-o com
             * $davis, se não, o valor de $davis sera usado para
             * instanciar um objeto da classe $repoClass.
             */

            if (empty($newDavisArray[$time->format('d/m/Y H:i')])) {
                $newDavisObject = $repository->findOneByDateTime($time);

                if ($newDavisObject instanceof $repoClass) {
                    $newDavisArray[$time->format('d/m/Y H:i')] = $newDavisObject->undoPrepare();
                    $newDavisArray[$time->format('d/m/Y H:i')]->mergeDavis($davis);
                    $newDavisObject = null;
                } else {
                    $newDavisArray[$time->format('d/m/Y H:i')] = new $repoClass($davis);
                    $newDavisArray[$time->format('d/m/Y H:i')]->mergeDavis($davis);
                }
            } else {
                $newDavisArray[$time->format('d/m/Y H:i')]->mergeDavis($davis);
            }
        }

        return $newDavisArray;
    }
}
