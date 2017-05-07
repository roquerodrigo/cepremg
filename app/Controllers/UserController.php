<?php

namespace App\Controllers;

use App\Models\User;
use Exception;
use Slim\Http\Request;
use Slim\Http\Response;

class UserController extends Controller
{
    /*
     * @route /user
     * @method GET
     */
    public function index(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'userArea.html.twig');
    }

    /*
     * @route /login
     * @method GET
     */
    public function loginForm(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'login.html.twig');
    }

    /*
     * @route /login
     * @method POST
     */
    public function login(Request $request, Response $response, array $args)
    {
        $uname = $request->getParsedBodyParam('uname');
        $pwd = $request->getParsedBodyParam('pwd');

        $pwd = hash('sha512', $pwd);

        try {
            $repository = $this->db->getRepository(User::class);
            $user = $repository->findOneBy(['username'=>$uname, 'password'=>$pwd]);
        } catch (Exception $e) {
            return $this->view->render($response, 'login.html.twig', ['failure'=>true]);
        }

        if ($user === null) {
            return $this->view->render($response, 'login.html.twig', ['failure'=>true]);
        }

        $_SESSION['name'] = $user->getName();
        $_SESSION['id'] = $user->getId();
        $_SESSION['auth'] = $user->getIsAble();
        $_SESSION['privilege'] = $user->getPrivilege();

        $this->view['session'] = $_SESSION;

        return $response->withStatus(200)->withHeader('Location', '/user');
    }

    /*
     * @route /logout
     * @method GET
     */
    public function logout(Request $request, Response $response, array $args)
    {
        session_unset();
        session_destroy();

        $this->view['session'] = [];

        return $response->withStatus(200)->withHeader('Location', '/login');
    }

    /*
     * @route /user/myaccount
     * @method GET
     */
    public function updateForm(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'updateUserForm.html.twig');
    }

    /*
     * @route /user/myaccount
     * @method POST
     */
    public function update(Request $request, Response $response, array $args)
    {
        $newPwd = $request->getParsedBodyParam('newPwd');
        $newPwdConfirm = $request->getParsedBodyParam('newPwdConfirm');
        $newName = $request->getParsedBodyParam('newName');

        if ($newPwd !== '') {
            if ($newPwd !== $newPwdConfirm) {
                return $this->view->render($response, 'createUserForm.html.twig', ['failure'=>true]);
            }
        }

        try {
            $user = $this->db->find(User::class, $_SESSION['id']);

            $user->setName($newName);
            $user->setId($_SESSION['id']);
            $user->setPassword(hash('sha512', $newPwd));

            $this->db->merge($user);
            $this->db->flush();
        } catch (Exception $e) {
            return $this->view->render($response, 'updateUserForm.html.twig', ['failure'=>true]);
        } finally {
            $_SESSION['name'] = $newName;
            $this->view['session'] = $_SESSION;
        }

        return $this->view->render($response, 'updateUserForm.html.twig', ['success' => true]);
    }
}
