<?php

namespace App\Controllers;

use App\Models\Davis;
use App\Models\DavisHourly;
use App\Models\DavisDaily;
use App\Models\DavisMonthly;
use App\Models\DavisYearly;
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

                /**
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
                $length = count($lines)-1;
                unset($lines[$length]);

                $davisArray = [];
                foreach ($lines as $i => $line) {
                 
                    $data = explode("\t", $line);
                    $dateTime = DateTime::createFromFormat('d/m/Y H:i', $data[0] . ' ' . $data[1]);
                    /**
                     * A aplicação não ira usar todos dados presentes no arquivo,
                     * os dados utilizados serão: 
                     * 1) Data e Hora
                     * 2) 
                     * 3) Maior Temperatura
                     * 4) Menor Temperatura
                     * 5) 
                     * 6) Direção do vento
                     * 7)
                     * 8) Chuva
                     * 9) Radiação Solar
                     * 10)
                     * 11) Velocidade do Vento
                     * Estão sendo atribuidos na mesma ordem.
                     */
                    if ($dateTime instanceof DateTime) {
                        $davis = new Davis();

                        $davis->setDateTime($dateTime)
                            ->setTempOut($data[2])
                            ->setHiTemp($data[3])
                            ->setLowTemp($data[4])
                            ->setOutHum($data[5])
                            ->setDewPt($data[6])
                            ->setWindDir($data[8])
                            ->setBar($data[16])
                            ->setRain($data[17])
                            ->setSolarRad($data[19])
                            ->setUVIndex($data[22]);

                        if ($convert) {
                            $davis->setWindSpeed($data[7] / 3.6);
                        } else {
                            $davis->setWindSpeed($data[7]);
                        }

                        $this->db->persist($davis);
                        unset($lines[$i]);
                        $davisArray[] = clone $davis;
                    } else {
                        throw new Exception('Erro na linha ' . ($i + 1));
                    }
                }
                                
                $this->db->flush();
                $davisArray = $this->generateDavis__($davisArray,DavisHourly::class);
                #echo '<pre>'.var_export($davisArray,true) . '</pre>';
                $this->db->flush();
                $davisArray = $this->generateDavis__($davisArray,DavisDaily::class);
                $this->db->flush();
                $davisArray = $this->generateDavis__($davisArray,DavisMonthly::class);
                
                $this->db->flush();
                $davisArray = $this->generateDavis__($davisArray,DavisYearly::class);
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

        return $this->view->render($response, 'import.html.twig', [
            'messages' => $messages,
        ]);
    }

    /**
     * @param Array $davisArray as intâncias irão variar de acordo com a chamada
     *
     * @return Array $newDavisArray
     */
    private function generateDavis__(&$davisArray,$repoClass) {
        $newDavisArray = [];
        $newDavisObject = NULL;
        $repository = $this->db->getRepository($repoClass);
        foreach ($davisArray as $i => $davis) {
            $time = new $repoClass($davis);
            $time = $time->getDateTime();
            /**
             * Checando se a posição do vetor contém algum valor,
             * caso tenha mesclar os valores de $davis, caso
             * contrário procurar um registro no banco de $repoClass.  
             * Se encontrado sera usado como base, mesclando-o com 
             * $davis, se não, o valor de $davis sera usado para
             * instanciar um objeto da classe $repoClass.
             */
            
            if(empty($newDavisArray[$time->format('d/m/Y H:i')])) {
                $newDavisObject = $repository->findOneByDateTime($time);

                if($newDavisObject instanceof $repoClass) {
                    $newDavisArray[$time->format('d/m/Y H:i')] = $newDavisObject->undoPrepare();
                    $newDavisArray[$time->format('d/m/Y H:i')]->mergeDavis($davis);
                    $newDavisObject = NULL;

                } else {
                    $newDavisArray[$time->format('d/m/Y H:i')] = new $repoClass($davis);
                }

            } else {
                $newDavisArray[$time->format('d/m/Y H:i')]->mergeDavis($davis);
            }

            unset($davisArray[$i]);
        }
        /**
         * Agora que as instâncias de $repoClass já estão prontas os valores
         * serão persistidos no SGBD.
         */
        #echo '<pre>'.var_export($newDavisArray,true) . '</pre>';
        foreach ($newDavisArray as $instance) {
            $this->db->merge($instance->doPrepare());
        }
        return $newDavisArray;        
    }

}
