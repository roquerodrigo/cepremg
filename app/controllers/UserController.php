<?php
namespace App\Controllers;

use App\models\User;
use Doctrine\ORM\QueryBuilder;
use Exception;
use Slim\Http\Request;
use Slim\Http\Response;

class UserController extends Controller
{
    public function showForm(Request $request, Response $response, array $args)
    {
      
       return $this->view->render($response, 'login.html.twig');
    }

    public function login(Request $request, Response $response, array $args)
    {
        // Não encontrei nada referente a recuperação de dados pelo slim
        $uname = $_POST['uname'];
        $pwd = $_POST['uname'];
        
        $query = $this->db->getRepository(User::class)->createQueryBuilder('User');
        
        $query->select('User.name')
              ->where('User.userName = :uname and User.password = :pwd')
              ->setParameter('uname',$uname)
              ->setParameter('pwd',$pwd);

        $result = $query->getQuery()->getArrayResult();
        
        if(count($result) != 1) {
            return $this->view->render($response,'login.html.twig',array('failure'=>true));
        } else {

            //session_start();
            $_SESSION['name'] = $result[0]['name'];
            $_SESSION['auth'] = true;

            $this->view['session'] = $_SESSION;
            return $this->view->render($response,'adminArea.html.twig');
        }
       //return $this->view->render($response, 'import.html.twig');*/
        
    }

    public function logout(Request $request, Response $response, array $args) 
    {
        session_unset();
        session_destroy();

        $this->view['session'] = array();
        return $this->view->render($response, 'data.html.twig');
    }
}

