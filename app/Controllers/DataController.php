<?php

namespace App\Controllers;

use App\Models\DavisDaily;
use App\Models\DavisHourly;
use App\Models\DavisMonthly;
use App\Models\DavisYearly;
use Doctrine\ORM\QueryBuilder;
use Ghunti\HighchartsPHP\Highchart;
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

        $chart = new Highchart(Highchart::HIGHSTOCK);
        $chart->xAxis->type = 'datetime';

        $chart->chart = [
            'height' => '500px',
            'type'   => 'line',
        ];

        switch ($type) {
            case 'temp':
                $chart->title->text = 'Temperatura';
                $chart->yAxis['title']['text'] = 'Temperatura (°C)';

                $chart->series['hiTemp']->name = 'Temperatura máxima';
                $chart->series['lowTemp']->name = 'Temperatura mínima';
                $chart->series['tempOut']->name = 'Temperatura média';

                break;

            case 'outHum':
                $chart->title->text = 'Umidade do ar';
                $chart->yAxis['title']['text'] = 'Umidade do ar (%)';

                $chart->series['outHum']->name = 'Umidade do ar';

                break;

            case 'dewPt':
                $chart->title->text = 'Temperatura de ponto de orvalho';
                $chart->yAxis['title']['text'] = 'Temperatura de ponto de orvalho (ºC)';

                $chart->series['dewPt']->name = 'Temperatura de ponto de orvalho';

                break;

            case 'dewPtTemp':
                $chart->title->text = 'Temperatura média e de ponto de orvalho';
                $chart->yAxis['title']['text'] = 'Temperatura (ºC)';

                $chart->series['dewPt']->name = 'Temperatura de ponto de orvalho';
                $chart->series['tempOut']->name = 'Temperatura média';
                break;

            case 'windSpeed':
                $chart->title->text = 'Intensidade do vento';
                $chart->yAxis['title']['text'] = 'Intensidade do vento (km/h)';

                $chart->series['windSpeed']->name = 'Intensidade do vento';

                break;

            case 'bar':
                $chart->title->text = 'Pressão atmosférica';
                $chart->yAxis['title']['text'] = 'Pressão atmosférica (hPa)';

                $chart->series['bar']->name = 'Pressão atmosférica';

                break;

            case 'rain':
                $chart->title->text = 'Precipitação';
                $chart->yAxis['title']['text'] = 'Precipitação (mm)';

                $chart->chart['type'] = 'bar';

                $chart->series['rain']->name = 'Precipitação';

                break;

            case 'solarRad':
                $chart->title->text = 'Radiação solar';
                $chart->yAxis['title']['text'] = 'Radiação solar (W/m²)';

                $chart->series['solarRad']->name = 'Radiação solar';

                break;

            case 'UVIndex':
                $chart->title->text = 'Índice ultra violeta';
                $chart->yAxis['title']['text'] = 'Índice ultra violeta (UV)';

                $chart->series['UVIndex']->name = 'Índice ultra violeta';

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
                ->andWhere('d.validHiTemp = 1')
                ->addSelect('d.lowTemp')
                ->andWhere('d.validLowTemp = 1')
                ->addSelect('d.tempOut')
                ->andWhere('d.validTempOut = 1');
        } else if ($type == 'dewPtTemp') {
            $qb->addSelect('d.tempOut')
                ->andWhere('d.validTempOut = 1')
                ->addSelect('d.dewPt')
                ->andWhere('d.validDewPt = 1');
        } else {
            $qb->addSelect('d.' . $type);
            $qb->andWhere('d.valid' . ucfirst($type) . ' = 1');
        }

        $results = $qb->getQuery()->getArrayResult();

        foreach ($results as $result) {
            $dateTime = $result['dateTime']->format('U') * 1000;

            if ($type == 'temp') {
                $chart->series['hiTemp']->data[] = [$dateTime, (float) $result['hiTemp']];
                $chart->series['lowTemp']->data[] = [$dateTime, (float) $result['lowTemp']];
                $chart->series['tempOut']->data[] = [$dateTime, (float) $result['tempOut']];
            } else if ($type == 'dewPtTemp') {
                $chart->series['tempOut']->data[] = [$dateTime, (float) $result['tempOut']];
                $chart->series['dewPt']->data[] = [$dateTime, (float) $result['dewPt']];
            } else {
                $chart->series[$type]->data[] = [$dateTime, (float) $result[$type]];
                $chart->series[$type]->gapSize = 1;
            }
        }

        return $chart->renderOptions();
    }

    public function index(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'data.html.twig');
    }
}
