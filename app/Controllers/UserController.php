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
        $uname = $request->getParsedBodyParam('uname');
        $pwd   = $request->getParsedBodyParam('pwd');

        $pwd = hash('sha512', $pwd);
        
        try {

            $repository = $this->db->getRepository(User::class);
            $user = $repository->findOneBy(array('username'=>$uname,'password'=>$pwd));
        
        } catch( Exception $e) {

            return $this->view->render($response, 'login.html.twig', ['failure'=>true]);
        
        }

        if ($user === null) 
            return $this->view->render($response, 'login.html.twig', ['failure'=>true]);
        
           
        $_SESSION['name'] = $user->getName();
        $_SESSION['id'] = $user->getId();
        $_SESSION['auth'] = $user->getIsAble();
        $_SESSION['privilege'] = $user->getPrivilege();

        $this->view['session'] = $_SESSION;

        return $response->withStatus(200)->withHeader('Location', '/user');
        
    }

    public function logout(Request $request, Response $response, array $args)
    {
            session_unset();
            session_destroy();

            $this->view['session'] = [];

            return $response->withStatus(200)->withHeader('Location', '/login');
    }

    public function createForm(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'createUserForm.html.twig');
    }

    public function create(Request $request, Response $response, array $args)
    {
        $username        = $request->getParsedBodyParam('uname');
        $password        = $request->getParsedBodyParam('pwd');
        $passwordConfirm = $request->getParsedBodyParam('pwdConfirm');
        $name            = $request->getParsedBodyParam('name');

        if ($password !== $passwordConfirm or $password == '') {
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
        
        $newPwd        = $request->getParsedBodyParam('newPwd');
        $newPwdConfirm = $request->getParsedBodyParam('newPwdConfirm');
        $newName       = $request->getParsedBodyParam('newName');

        if ($newPwd !== '') {

            if($newPwd !== $newPwdConfirm) {

              return $this->view->render($response, 'createUserForm.html.twig', ['failure'=>true]);
            }

        }
        
        $user = $this->db->find(User::class, $_SESSION['id']);
        $user->setName($newName);
        $user->setId($_SESSION['id']);
        $user->setPassword(hash('sha512', $newPwd));
       
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

    public function deleteForm(Request $request, Response $response, array $args)
    {
        try{
            $repository = $this->db->getRepository(User::class);
            $users = $repository->findByPrivilege(1);
        } catch (Exception $e) {
            $e->getMessage();
            return;
        } 

        if(count($users) === 0)
        {
           # ARRAY VAZIO MANDAR PAGINA COM AVISO 
        }
        
        $enabled = array();
        $disabled = array();
        foreach ($users as $user) {

            if($user.getIsAble() == true) {

                array_push($enabled,array(
                    'name'=>$user->getName(),
                    'id'  =>$user->getId()));
            } else {

                array_push($disabled,array(
                    'name'=>$user->getName(),
                    'id'=>$user->getId()));
            }
        }

        return $this->view->render($response, 'deleteUserForm.html.twig',
            ['Enabled' => $enabled,
             'Disabled'=> $disabled]);
    }

    public function delete(Request $request, Response $response, array $args) {
        var_dump($_POST);
    }

}
