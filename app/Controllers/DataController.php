<?php

namespace App\Controllers;

use App\Models\DavisDaily;
use App\Models\DavisHourly;
use App\Models\DavisMonthly;
use App\Models\DavisYearly;
use Doctrine\ORM\QueryBuilder;
use Slim\Http\Request;
use Slim\Http\Response;

class DataController extends Controller
{
    public function getData(Request $request, Response $response, array $args)
    {
        $type = $args['type'];
        $start = $args['start'];
        $end = $args['end'];
        $timePeriod = $args['timePeriod'];

        $chartType = 'spline';
        $series = [];

        switch ($type) {
            case 'temp':
                $chartName = 'Temperatura';
                $unidadeMedida = 'Temperatura (ºC)';
                $series['hiTemp']['name'] = 'Temperatura máxima';
                $series['lowTemp']['name'] = 'Temperatura mínima';
                $series['tempOut']['name'] = 'Temperatura média';
                break;

            case 'outHum':
                $chartName = 'Umidade do ar';
                $unidadeMedida = 'Umidade do ar (%)';
                $series['outHum']['name'] = 'Umidade do ar';
                break;

            case 'dewPt':
                $chartName = 'Temperatura de ponto de orvalho';
                $unidadeMedida = 'Temperatura de ponto de orvalho (ºC)';
                $series['dewPt']['name'] = 'Temperatura de ponto de orvalho';
                break;

            case 'windSpeed':
                $chartName = 'Intensidade do vento';
                $unidadeMedida = 'Intensidade do vento (km/h)';
                $series['windSpeed']['name'] = 'Intensidade do vento';
                break;

            case 'bar':
                $chartName = 'Pressão atmosférica';
                $unidadeMedida = 'Pressão atmosférica (hPa)';
                $series['bar']['name'] = 'Pressão atmosférica';
                break;

            case 'rain':
                $chartName = 'Precipitação';
                $unidadeMedida = 'Precipitação (mm)';
                $series['rain']['name'] = 'Precipitação';
                $chartType = 'bar';
                break;

            case 'solarRad':
                $chartName = 'Radiação solar';
                $unidadeMedida = 'Radiação solar (W/m²)';
                $series['solarRad']['name'] = 'Radiação solar';
                break;

            case 'UVIndex':
                $chartName = 'Índice ultra violeta';
                $unidadeMedida = 'Índice ultra violeta (UV)';
                $series['UVIndex']['name'] = 'Índice ultra violeta';
                break;
            default:
                return $response->withStatus(404);
                break;
        }

        switch ($timePeriod) {
            case 'daily':
                $qb = $this->db->getRepository(DavisDaily::class);
                break;
            case 'hourly':
                $qb = $this->db->getRepository(DavisHourly::class);
                break;
            case 'monthly':
                $qb = $this->db->getRepository(DavisMonthly::class);
                break;
            case 'yearly':
                $qb = $this->db->getRepository(DavisYearly::class);
                break;
            default:
                return $response->withStatus(404);
                break;
        }

        /** @var QueryBuilder $qb */
        $qb = $qb->createQueryBuilder('d');

        $qb->select('d.dateTime')
            ->where($qb->expr()->between('d.dateTime', ':start', ':end'))
            ->setParameter('start', $start)
            ->setParameter('end', $end);

        if ($type == 'temp') {
            $qb->addSelect('d.hiTemp')
                ->addSelect('d.lowTemp')
                ->addSelect('d.tempOut');
        } else {
            $qb->addSelect('d.' . $type);
        }

        $results = $qb->getQuery()->getArrayResult();
        foreach ($results as $result) {
            $dateTime = $result['dateTime']->format('U') * 1000;

            if ($type == 'temp') {
                $series['hiTemp']['data'][] = [$dateTime, (float) $result['hiTemp']];
                $series['lowTemp']['data'][] = [$dateTime, (float) $result['lowTemp']];
                $series['tempOut']['data'][] = [$dateTime, (float) $result['tempOut']];
            } else {
                $series[$type]['data'][] = [$dateTime, (float) $result[$type]];
            }
        }

        return $response->withJson([
            'chart'  => [
                'height'       => 500,
                'type'         => $chartType,
                'connectNulls' => false,
            ],
            'series' => $series,
            'title'  => [
                'text' => $chartName,
            ],
            'xAxis'  => [
                'type'  => 'datetime',
                'title' => [
                    'text' => 'Data',
                ],
            ],
            'yAxis'  => [
                'title' => [
                    'text' => $unidadeMedida,
                ],
            ],
        ]);
    }

    public function index(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'data.html.twig');
    }
}
