<?php

namespace App\Controllers;

use App\Models\DavisDaily;
use App\Models\DavisHourly;
use App\Models\DavisMonthly;
use App\Models\DavisYearly;
use App\Models\User;
use Exception;
use Slim\Http\Request;
use Slim\Http\Response;

class AdminController extends Controller
{
    /**
     * @route /admin/data-overview
     *
     * @method GET
     */
    public function dataOverview(Request $request, Response $response, array $args)
    {
        $repo = $this->db->getRepository(DavisHourly::class)->findAll();
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

        $repo = $this->db->getRepository(DavisDaily::class)->findAll();
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

        $repo = $this->db->getRepository(DavisMonthly::class)->findAll();
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

        $repo = $this->db->getRepository(DavisYearly::class)->findAll();
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

        return $this->view->render($response, 'dataOverview.html.twig', ['hourly' => $meta_hourly, 'daily' => $meta_daily, 'monthly' => $meta_monthly, 'yearly' => $meta_yearly]);
    }

    /*
     * @route /admin/register-user
     * @method GET
     */
    public function createForm(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'createUserForm.html.twig',
            ['message'=> $args['message']]);
    }

    /*
     * @route /admin/register-user[/{message}]
     * @method POST
     */
    public function create(Request $request, Response $response, array $args)
    {
        $username = $request->getParsedBodyParam('uname');
        $password = $request->getParsedBodyParam('pwd');
        $passwordConfirm = $request->getParsedBodyParam('pwdConfirm');
        $name = $request->getParsedBodyParam('name');

        if ($password !== $passwordConfirm or $password == '') {
            return $response->withStatus(200)->withHeader('Location', '/admin/register-user/failure');
        }

        $user = new User();
        $user->setUserName($username);
        $user->setPassword(hash('sha512', $password));
        $user->setName($name);

        try {
            $this->db->persist($user);
            $this->db->flush();
        } catch (Exception $e) {
            return $response->withStatus(200)->withHeader('Location', '/admin/register-user/failure');
        }

        return $response->withStatus(200)->withHeader('Location', '/admin/register-user/success');
    }

    /*
     * @route /admin/disable-user
     * @method GET
     */
    public function deleteForm(Request $request, Response $response, array $args)
    {
        $users = $this->getEnabledAndDisabledUsers();
        if ($users == null || count($users) == 0) {
            return $this->view->render($response, 'deleteUserForm.html.twig',
                ['warning_message'=> 'Não há usuários cadastrados.']);
        }

        return $this->view->render($response, 'deleteUserForm.html.twig',
            ['Enabled' => $users[0],
             'Disabled'=> $users[1], ]);
    }

    private function getEnabledAndDisabledUsers()
    {
        try {
            $repository = $this->db->getRepository(User::class);
            $users = $repository->findByPrivilege(1);
        } catch (Exception $e) {
            $e->getMessage();

            return;
        }

        if (count($users) === 0) {
            return $users;
        }

        $enabled = [];
        $disabled = [];
        foreach ($users as $user) {
            if ($user->getIsAble() == true) {
                array_push($enabled, [
                    'name'=> $user->getName(),
                    'id'  => $user->getId(), ]);
            } else {
                array_push($disabled, [
                    'name'=> $user->getName(),
                    'id'  => $user->getId(), ]);
            }
        }

        return [$enabled, $disabled];
    }

    /*
     * @route /admin/disable-user
     * @method POST
     */

    public function delete(Request $request, Response $response, array $args)
    {
        $postParams = $request->getParsedBody();
        try {
            foreach ($postParams['usersToDisableId'] as $id) {
                $user = $this->db->find(User::class, $id);
                $user->setIsAble(false);
                $this->db->persist($user);
            }

            foreach ($postParams['usersToEnableId'] as $id) {
                $user = $this->db->find(User::class, $id);
                $user->setIsAble(true);
                $this->db->persist($user);
            }
            $this->db->flush();
        } catch (Exception $e) {
            return 'Erro: ' . $e->getMessage();
        }
        $users = $this->getEnabledAndDisabledUsers();

        return $this->view->render($response, 'partials/deleteUsersTable.html.twig',
            ['Enabled'  => $users[0],
              'Disabled'=> $users[1], ]);
    }
}
