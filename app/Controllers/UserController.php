<?php

namespace App\Controllers;

use App\Models\User;
use Exception;
use Slim\Http\Request;
use Slim\Http\Response;

class UserController extends Controller
{
    public function index(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'adminArea.html.twig');
    }

    public function loginForm(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'login.html.twig');
    }

    public function login(Request $request, Response $response, array $args)
    {
        $uname = $_POST['uname'];
        $pwd = hash('sha512', $_POST['pwd']);

        $query = $this->db->getRepository(User::class)->createQueryBuilder('User');

        $query->select('User.name, User.id')
              ->where('User.username = :uname and User.password = :pwd')
              ->setParameter('uname', $uname)
              ->setParameter('pwd', $pwd);

        $result = $query->getQuery()->getArrayResult();

        if (count($result) != 1) {
            return $this->view->render($response, 'login.html.twig', ['failure'=>true]);
        } else {
            $_SESSION['name'] = $result[0]['name'];
            $_SESSION['id'] = $result[0]['id'];
            $_SESSION['auth'] = true;

            $this->view['session'] = $_SESSION;

            return $this->view->render($response, 'adminArea.html.twig');
        }
    }

    public function logout(Request $request, Response $response, array $args)
    {
            session_unset();
            session_destroy();

            $this->view['session'] = [];

            return $this->view->render($response, 'data.html.twig');
    }

    public function createForm(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'createUserForm.html.twig');
    }

    public function create(Request $request, Response $response, array $args)
    {
        $username = $_POST['uname'];
        $password = $_POST['pwd'];
        $passwordConfirm = $_POST['pwdConfirm'];
        $name = $_POST['name'];
        if ($password !== $passwordConfirm) {
            return $this->view->render($response, 'createUserForm.html.twig', ['failure'=>true]);
        }
         
        $user = new User();
        $user->setUserName($username);
        $user->setPassword(hash('sha512', $password));
        $user->setName($name);

        try {
            $this->db->persist($user);
            $this->db->flush();
        } catch (Exception $e) {
            return $this->view->render($response, 'createUserForm.html.twig', ['failure'=>true, 'message'=>': Usuário já cadastrado']);
        }

        return $this->view->render($response, 'createUserForm.html.twig', ['success'=>true]);
    }

    public function updateForm(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'updateUserForm.html.twig');
    }

    public function update(Request $request, Response $response, array $args)
    {
        extract($_POST);

        if ($newPwd !== $newPwdConfirm) {
            return $this->view->render($response, 'createUserForm.html.twig', ['failure'=>true]);
        }

        $user = $this->db->find(User::class, $_SESSION['id']);
        $user->setName($newName);
        if ($newPwd !== '') {
            $user->setPassword(hash('sha512', $newPwd));
        }
        $user->setId($_SESSION['id']);
        try {
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
