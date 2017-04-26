<?php

namespace App\Controllers;

use App\Models\Davis;
use Doctrine\ORM\QueryBuilder;
use DoctrineExtensions\Query\Mysql\Date;
use DoctrineExtensions\Query\Mysql\Hour;
use Slim\Http\Request;
use Slim\Http\Response;

class DataController extends Controller
{
    public function getData(Request $request, Response $response, array $args)
    {
        $type = $args['type'];
        $start = $args['start'];
        $end = $args['end'];

        if (!in_array($type, ['temp', 'outHum', 'dewPt', 'windSpeed', 'bar', 'rain', 'solarRad', 'UVIndex'])) {
            return $response->withStatus(404);
        }

        $this->db->getConfiguration()->addCustomDatetimeFunction('DATE', Date::class);
        $this->db->getConfiguration()->addCustomDatetimeFunction('HOUR', Hour::class);

        /** @var QueryBuilder $qb */
        $qb = $this->db->getRepository(Davis::class)->createQueryBuilder('u');

        $qb->select('DATE(u.dateTime) AS date')
            ->addSelect('HOUR(u.dateTime) AS hour')
            ->where($qb->expr()->between('u.dateTime', ':start', ':end'))
            ->groupBy('date', 'hour')
            ->having('COUNT(hour) >= 6')
            ->setParameter('start', $start)
            ->setParameter('end', $end);
//            ->setParameter('start', '2016-01-01 00:00:00')
//            ->setParameter('end', '2016-01-02 00:00:00');

        $chartName = '';
        $chartType = 'spline';
        $unidadeMedida = '';
        $series = [];

        switch ($args['type']) {
            case 'temp':
                $chartName = 'Temperatura';
                $unidadeMedida = 'Temperatura (ºC)';
                $series['hiTemp']['name'] = 'Temperatura máxima';
                $series['lowTemp']['name'] = 'Temperatura mínima';
                $series['tempOut']['name'] = 'Temperatura média';

                $qb->addSelect('MAX(u.hiTemp) AS hiTemp')
                    ->addSelect('MIN(u.lowTemp) AS lowTemp')
                    ->addSelect('AVG(u.tempOut) AS tempOut');
                break;

            case 'outHum':
                $chartName = 'Umidade do ar';
                $unidadeMedida = 'Umidade do ar (%)';
                $series['outHum']['name'] = 'Umidade do ar';

                $qb->addSelect('AVG(u.outHum) AS outHum');
                break;

            case 'dewPt':
                $chartName = 'Temperatura de ponto de orvalho';
                $unidadeMedida = 'Temperatura de ponto de orvalho (ºC)';
                $series['dewPt']['name'] = 'Temperatura de ponto de orvalho';

                $qb->addSelect('AVG(u.dewPt) AS dewPt');
                break;

            case 'windSpeed':
                $chartName = 'Intensidade do vento';
                $unidadeMedida = 'Intensidade do vento (km/h)';
                $series['windSpeed']['name'] = 'Intensidade do vento';

                $qb->addSelect('AVG(u.windSpeed) AS windSpeed');
                break;

            case 'bar':
                $chartName = 'Pressão atmosférica';
                $unidadeMedida = 'Pressão atmosférica (hPa)';
                $series['bar']['name'] = 'Pressão atmosférica';

                $qb->addSelect('AVG(u.bar) AS bar');
                break;

            case 'rain':
                $chartName = 'Precipitação';
                $unidadeMedida = 'Precipitação (mm)';
                $series['rain']['name'] = 'Precipitação';
                $chartType = 'bar';

                $qb->addSelect('SUM(u.rain) AS rain');
                break;

            case 'solarRad':
                $chartName = 'Radiação solar';
                $unidadeMedida = 'Radiação solar (W/m²)';
                $series['solarRad']['name'] = 'Radiação solar';

                $qb->addSelect('AVG(u.solarRad) AS solarRad');
                break;

            case 'UVIndex':
                $chartName = 'Índice ultra violeta';
                $unidadeMedida = 'Índice ultra violeta (UV)';
                $series['UVIndex']['name'] = 'Índice ultra violeta';

                $qb->addSelect('AVG(u.UVIndex) AS UVIndex');
                break;
        }

        $results = $qb->getQuery()->getArrayResult();

        foreach ($results as $result) {
            $date = explode('-', $result['date']);
            $dateTime = mktime($result['hour'], 0, 0, $date[1], $date[2], $date[0]) * 1000;

            if ($type == 'temp') {
                $series['hiTemp']['data'][] = [$dateTime, (float)$result['hiTemp']];
                $series['lowTemp']['data'][] = [$dateTime, (float)$result['lowTemp']];
                $series['tempOut']['data'][] = [$dateTime, (float)$result['tempOut']];
            } else {
                $series[$type]['data'][] = [$dateTime, (float)$result[$type]];
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