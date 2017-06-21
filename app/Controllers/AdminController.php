<?php

namespace App\Controllers;

use App\Models\User;
use Exception;
use Slim\Http\Request;
use Slim\Http\Response;

class AdminController extends Controller
{
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
