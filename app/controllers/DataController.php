<?php

namespace App\Controllers;

use App\Models\Davis;
use DoctrineExtensions\Query\Mysql\Date;
use DoctrineExtensions\Query\Mysql\DateFormat;
use DoctrineExtensions\Query\Mysql\Hour;
use Slim\Http\Request;
use Slim\Http\Response;

class DataController extends Controller
{
    public function getData(Request $request, Response $response, array $args)
    {
        $this->db->getConfiguration()->addCustomDatetimeFunction('DATE', Date::class);
        $this->db->getConfiguration()->addCustomDatetimeFunction('HOUR', Hour::class);
        $this->db->getConfiguration()->addCustomDatetimeFunction('DATE_FORMAT', DateFormat::class);

        $qb = $this->db->getRepository(Davis::class)
            ->createQueryBuilder('u');

        $davis = $qb
            ->select('DATE(u.dateTime) AS date')
            ->addSelect('HOUR(u.dateTime) AS hour')
            ->addSelect('MAX(u.hiTemp) AS hiTemp')
            ->addSelect('MIN(u.lowTemp) AS lowTemp')
            ->addSelect('AVG(u.tempOut) AS tempOut')
            ->addSelect('AVG(u.outHum) AS outHum')
            ->addSelect('AVG(u.dewPt) AS dewPt')
            ->addSelect('AVG(u.windSpeed) AS windSpeed')
            ->addSelect('AVG(u.bar) AS bar')
            ->addSelect('SUM(u.rain) AS rain')
            ->addSelect('AVG(u.solarRad) AS solarRad')
            ->addSelect('AVG(u.UVIndex) AS UVIndex')
            ->where($qb->expr()->between('u.dateTime', ':start', ':end'))
            ->groupBy('date', 'hour')
            ->having('COUNT(hour) >= 6')
            ->setParameter('start', '2016-01-01 00:00:00')
            ->setParameter('end', '2016-01-02 00:00:00')
            ->getQuery()
            ->getArrayResult();

        return $response->withJson($davis);
    }

    public function index(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'data.html.twig');
    }
}