<?php

namespace App\Controllers;

use App\Models\User;
use Exception;
use Slim\Http\Request;
use Slim\Http\Response;

class AdminController extends Controller
{

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
           return $this->view->render($response, 'deleteUserForm.html.twig',
            ['warning_message'=>'Não há usuários cadastrados.']);
        }
        
        $enabled = array();
        $disabled = array();
        foreach ($users as $user) {

            if($user->getIsAble() == true) {

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

    public function delete(Request $request, Response $response, array $args) 
    {

        $disable = $request->getParsedBodyParam('disable');
        $enable = $request->getParsedBodyParam('enable');

        try{

           foreach ($disable as $userId) {
              $user = $this->db->find(User::class, $userId);
              $user->setIsAble(false);
              $this->db->merge($user);
            }

            foreach ($enable as $userId) {
              $user = $this->db->find(User::class, $userId);
              $user->setIsAble(true);
              $this->db->merge($user);
            }

            $this->db->flush();

        } catch(Exception $e) {

            echo $e->getMessage();
            return;

        } finally {

            return $response->withStatus(200)->withHeader('Location', '/admin/disable');
        }
        
    }

}
