<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class OverviewController extends Controller
{
    public function index(Request $request, Response $response, array $args)
    {
        $repo = $this->db->createQuery("SELECT h FROM App\Models\DavisHourly h")->setFirstResult(0)->setMaxResults(10)->getResult();
        $meta_hourly = [];
        foreach ($repo as $davis) {
            $meta_hourly[$davis->getDateTime()->format('d/m/Y H')]['WindSpeed'] = $davis->getAmountWindSpeed() / $davis->getAmountData();
            $meta_hourly[$davis->getDateTime()->format('d/m/Y H')]['LowTemp'] = $davis->getAmountLowTemp() / $davis->getAmountData();
            $meta_hourly[$davis->getDateTime()->format('d/m/Y H')]['HiTemp'] = $davis->getAmountHiTemp() / $davis->getAmountData();
        }

        $repo = $this->db->createQuery("SELECT y FROM App\Models\DavisDaily y")->setFirstResult(0)->setMaxResults(10)->getResult();
        $meta_daily = [];
        foreach ($repo as $davis) {
            $meta_daily[$davis->getDateTime()->format('d/m/Y')]['WindSpeed'] = array_sum($davis->getAmountWindSpeed()) / $davis->getAmountData();
            $meta_daily[$davis->getDateTime()->format('d/m/Y')]['LowTemp'] = array_sum($davis->getAmountLowTemp()) / $davis->getAmountData();
            $meta_daily[$davis->getDateTime()->format('d/m/Y')]['HiTemp'] = array_sum($davis->getAmountHiTemp()) / $davis->getAmountData();
        }

        $repo = $this->db->createQuery("SELECT y FROM App\Models\DavisMonthly y")->setFirstResult(0)->setMaxResults(10)->getResult();
        $meta_monthly = [];
        foreach ($repo as $davis) {
            $meta_monthly[$davis->getDateTime()->format('m/Y')]['WindSpeed'] = $davis->getAmountWindSpeed() / $davis->getAmountData();
            $meta_monthly[$davis->getDateTime()->format('m/Y')]['LowTemp'] = $davis->getAmountLowTemp() / $davis->getAmountData();
            $meta_monthly[$davis->getDateTime()->format('m/Y')]['HiTemp'] = $davis->getAmountHiTemp() / $davis->getAmountData();
        }

        $repo = $this->db->createQuery("SELECT y FROM App\Models\DavisYearly y")->setFirstResult(0)->setMaxResults(10)->getResult();
        $meta_yearly = [];
        foreach ($repo as $davis) {
            $meta_yearly[$davis->getDateTime()->format('Y')]['WindSpeed'] = array_sum($davis->getAmountWindSpeed()) / $davis->getAmountData();
            $meta_yearly[$davis->getDateTime()->format('Y')]['LowTemp'] = array_sum($davis->getAmountLowTemp()) / $davis->getAmountData();
            $meta_yearly[$davis->getDateTime()->format('Y')]['HiTemp'] = array_sum($davis->getAmountHiTemp()) / $davis->getAmountData();
        }

        return $this->view->render($response, 'overview.html.twig', ['hourly' => $meta_hourly, 'daily' => $meta_daily, 'monthly' => $meta_monthly, 'yearly' => $meta_yearly]);
    }

    public function getOverview(Request $request, Response $response, array $args)
    {
        $tipo = explode('/', $request->getUri())[5];
        $dados = [];
        if ($tipo === 'hourly') {
            $dados = $this->overViewOurly(100, 0);
        } elseif ($tipo === 'daily') {
            $dados = $this->overViewDaily(100, 0);
        } elseif ($tipo === 'monthly') {
            $dados = $this->overViewMonthly(100, 0);
        } elseif ($tipo === 'yearly') {
            $dados = $this->overViewYearly(100, 0);
        }
        $this->view->render($response, 'dataOverview.html.twig', ['nome'=>ucfirst($tipo), 'dados'=>$dados, 'tipo'=>$tipo]);
    }

    public function verMais(Request $request, Response $response, array $args)
    {
        $tipo = $request->getParsedBody()['tipo'];
        $offset = $request->getParsedBody()['offset'];
        $dados = [];
        if ($tipo === 'hourly') {
            $dados = $this->overViewOurly(100, $offset);
        } elseif ($tipo === 'daily') {
            $dados = $this->overViewDaily(100, $offset);
        } elseif ($tipo === 'monthly') {
            $dados = $this->overViewMonthly(100, $offset);
        } elseif ($tipo === 'yearly') {
            $dados = $this->overViewYearly(100, $offset);
        }
        $this->view->render($response, 'partials/overviewPartial.html.twig', ['dados'=>$dados]);
    }

    private function overViewOurly($max, $offset)
    {
        $repo = $this->db->createQuery("SELECT h FROM App\Models\DavisHourly h")->setFirstResult($offset * $max)->setMaxResults($max)->getResult();
        $meta_hourly = [];
        foreach ($repo as $davis) {
            $meta_hourly[$davis->getDateTime()->format('d/m/Y H')]['UVIndex'] = $davis->getAmountUVIndex() / $davis->getAmountData();
            $meta_hourly[$davis->getDateTime()->format('d/m/Y H')]['SolarRad'] = $davis->getAmountSolarRad() / $davis->getAmountData();
            $meta_hourly[$davis->getDateTime()->format('d/m/Y H')]['Rain'] = $davis->getAmountRain() / $davis->getAmountData();
            $meta_hourly[$davis->getDateTime()->format('d/m/Y H')]['Bar'] = $davis->getAmountBar() / $davis->getAmountData();
            $meta_hourly[$davis->getDateTime()->format('d/m/Y H')]['WindSpeed'] = $davis->getAmountWindSpeed() / $davis->getAmountData();
            $meta_hourly[$davis->getDateTime()->format('d/m/Y H')]['OutHum'] = $davis->getAmountOutHum() / $davis->getAmountData();
            $meta_hourly[$davis->getDateTime()->format('d/m/Y H')]['LowTemp'] = $davis->getAmountLowTemp() / $davis->getAmountData();
            $meta_hourly[$davis->getDateTime()->format('d/m/Y H')]['DewPt'] = $davis->getAmountDewPt() / $davis->getAmountData();
            $meta_hourly[$davis->getDateTime()->format('d/m/Y H')]['HiTemp'] = $davis->getAmountHiTemp() / $davis->getAmountData();
            $meta_hourly[$davis->getDateTime()->format('d/m/Y H')]['TempOut'] = $davis->getAmountTempOut() / $davis->getAmountData();
        }

        return $meta_hourly;
    }

    private function overViewDaily($max, $offset)
    {
        $repo = $this->db->createQuery("SELECT y FROM App\Models\DavisDaily y")->setFirstResult($offset * $max)->setMaxResults($max)->getResult();
        $meta_daily = [];
        foreach ($repo as $davis) {
            $meta_daily[$davis->getDateTime()->format('d/m/Y')]['UVIndex'] = array_sum($davis->getAmountUVIndex()) / $davis->getAmountData();
            $meta_daily[$davis->getDateTime()->format('d/m/Y')]['SolarRad'] = array_sum($davis->getAmountSolarRad()) / $davis->getAmountData();
            $meta_daily[$davis->getDateTime()->format('d/m/Y')]['Rain'] = array_sum($davis->getAmountRain()) / $davis->getAmountData();
            $meta_daily[$davis->getDateTime()->format('d/m/Y')]['Bar'] = array_sum($davis->getAmountBar()) / $davis->getAmountData();
            $meta_daily[$davis->getDateTime()->format('d/m/Y')]['WindSpeed'] = array_sum($davis->getAmountWindSpeed()) / $davis->getAmountData();
            $meta_daily[$davis->getDateTime()->format('d/m/Y')]['OutHum'] = array_sum($davis->getAmountOutHum()) / $davis->getAmountData();
            $meta_daily[$davis->getDateTime()->format('d/m/Y')]['LowTemp'] = array_sum($davis->getAmountLowTemp()) / $davis->getAmountData();
            $meta_daily[$davis->getDateTime()->format('d/m/Y')]['DewPt'] = array_sum($davis->getAmountDewPt()) / $davis->getAmountData();
            $meta_daily[$davis->getDateTime()->format('d/m/Y')]['HiTemp'] = array_sum($davis->getAmountHiTemp()) / $davis->getAmountData();
            $meta_daily[$davis->getDateTime()->format('d/m/Y')]['TempOut'] = array_sum($davis->getAmountTempOut()) / $davis->getAmountData();
        }

        return $meta_daily;
    }

    private function overViewMonthly($max, $offset)
    {
        $repo = $this->db->createQuery("SELECT y FROM App\Models\DavisMonthly y")->setFirstResult($offset * $max)->setMaxResults($max)->getResult();
        $meta_monthly = [];
        foreach ($repo as $davis) {
            $meta_monthly[$davis->getDateTime()->format('m/Y')]['UVIndex'] = $davis->getAmountUVIndex() / $davis->getAmountData();
            $meta_monthly[$davis->getDateTime()->format('m/Y')]['SolarRad'] = $davis->getAmountSolarRad() / $davis->getAmountData();
            $meta_monthly[$davis->getDateTime()->format('m/Y')]['Rain'] = $davis->getAmountRain() / $davis->getAmountData();
            $meta_monthly[$davis->getDateTime()->format('m/Y')]['Bar'] = $davis->getAmountBar() / $davis->getAmountData();
            $meta_monthly[$davis->getDateTime()->format('m/Y')]['WindSpeed'] = $davis->getAmountWindSpeed() / $davis->getAmountData();
            $meta_monthly[$davis->getDateTime()->format('m/Y')]['OutHum'] = $davis->getAmountOutHum() / $davis->getAmountData();
            $meta_monthly[$davis->getDateTime()->format('m/Y')]['LowTemp'] = $davis->getAmountLowTemp() / $davis->getAmountData();
            $meta_monthly[$davis->getDateTime()->format('m/Y')]['DewPt'] = $davis->getAmountDewPt() / $davis->getAmountData();
            $meta_monthly[$davis->getDateTime()->format('m/Y')]['HiTemp'] = $davis->getAmountHiTemp() / $davis->getAmountData();
            $meta_monthly[$davis->getDateTime()->format('m/Y')]['TempOut'] = $davis->getAmountTempOut() / $davis->getAmountData();
        }

        return $meta_monthly;
    }

    private function overViewYearly($max, $offset)
    {
        $repo = $this->db->createQuery("SELECT y FROM App\Models\DavisYearly y")->setFirstResult($offset * $max)->setMaxResults($max)->getResult();
        $meta_yearly = [];
        foreach ($repo as $davis) {
            $meta_yearly[$davis->getDateTime()->format('Y')]['UVIndex'] = array_sum($davis->getAmountUVIndex()) / $davis->getAmountData();
            $meta_yearly[$davis->getDateTime()->format('Y')]['SolarRad'] = array_sum($davis->getAmountSolarRad()) / $davis->getAmountData();
            $meta_yearly[$davis->getDateTime()->format('Y')]['Rain'] = array_sum($davis->getAmountRain()) / $davis->getAmountData();
            $meta_yearly[$davis->getDateTime()->format('Y')]['Bar'] = array_sum($davis->getAmountBar()) / $davis->getAmountData();
            $meta_yearly[$davis->getDateTime()->format('Y')]['WindSpeed'] = array_sum($davis->getAmountWindSpeed()) / $davis->getAmountData();
            $meta_yearly[$davis->getDateTime()->format('Y')]['OutHum'] = array_sum($davis->getAmountOutHum()) / $davis->getAmountData();
            $meta_yearly[$davis->getDateTime()->format('Y')]['LowTemp'] = array_sum($davis->getAmountLowTemp()) / $davis->getAmountData();
            $meta_yearly[$davis->getDateTime()->format('Y')]['DewPt'] = array_sum($davis->getAmountDewPt()) / $davis->getAmountData();
            $meta_yearly[$davis->getDateTime()->format('Y')]['HiTemp'] = array_sum($davis->getAmountHiTemp()) / $davis->getAmountData();
            $meta_yearly[$davis->getDateTime()->format('Y')]['TempOut'] = array_sum($davis->getAmountTempOut()) / $davis->getAmountData();
        }

        return $meta_yearly;
    }
}
