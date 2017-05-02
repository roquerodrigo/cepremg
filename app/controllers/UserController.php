<?php
namespace App\Controllers;

use App\models\User;
use Doctrine\ORM\QueryBuilder;
use Exception;
use Slim\Http\Request;
use Slim\Http\Response;

class UserController extends Controller
{
    public function index(Request $request, Response $response, array $args){
        if($this->view['session']['auth'] === true) {
          return $this->view->render($response,'adminArea.html.twig'); 
        }
        /*
         * Redirecionar para página de erro 404.
         */
        return $this->view->render($response, 'data.html.twig');
    }
    public function showForm(Request $request, Response $response, array $args)
    {
      
       return $this->view->render($response, 'login.html.twig');
    }

    public function login(Request $request, Response $response, array $args)
    {
        
        $uname = $_POST['uname'];
        $pwd = $_POST['pwd'];
        
        $query = $this->db->getRepository(User::class)->createQueryBuilder('User');
        
        $query->select('User.name')
              ->where('User.userName = :uname and User.password = :pwd')
              ->setParameter('uname',$uname)
              ->setParameter('pwd',$pwd);

        $result = $query->getQuery()->getArrayResult();
        
        if(count($result) != 1) {
            return $this->view->render($response,'login.html.twig',array('failure'=>true));
        } else {

            $_SESSION['name'] = $result[0]['name'];
            $_SESSION['auth'] = true;

            $this->view['session'] = $_SESSION;
            return $this->view->render($response,'adminArea.html.twig');
        }
       
        
    }

    public function logout(Request $request, Response $response, array $args) 
    {
        if($this->view['session']['auth'] === true) {
            session_unset();
            session_destroy();

           $this->view['session'] = array();
            return $this->view->render($response, 'data.html.twig');
        } else {
            /*
             * Redirecionar para página de erro 404.
             */
            return $this->view->render($response, 'data.html.twig');
        }
    }

    public function createForm(Request $request, Response $response, array $args)
    {
        if($this->view['session']['auth'] === true) {
            return $this->view->render($response, 'createUserForm.html.twig');
        }
        /*
         * Redirecionar para página de erro 404.
         */
        return $this->view->render($response, 'data.html.twig');
    }

    public function create(Request $request, Response $response, array $args)
    {
        if($this->view['session']['auth'] === true) {
            $username = $_POST['uname'];
            $password = $_POST['pwd'];
            $passwordConfirm = $_POST['pwdConfirm'];
            $name = $_POST['name'];
            if($password !== $passwordConfirm) {
                return $this->view->render($response,'createUserForm.html.twig',array('failure'=>true));
            }

            $user = new User;
            $user->username = '$username;';
            $user->password = hash('sha512',$password);
            $user->name = $name;
            try{
                $this->db->persist($user);
                $this->db->flush();
            } catch (Exception $e ) {
                return $this->view->render($response,'createUserForm.html.twig',array('failure'=>true,'message'=>': Usuário já cadastrado'));
            }
            return $this->view->render($response,'createUserForm.html.twig',array('success'=>true));

        }
        return $this->view->render($response, 'data.html.twig');
    }
}

