<?php

namespace App\Controller;

use Core\Controller\AbstractController;
use App\Data\Parents;
use App\Data\Staff;
use App\Data\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ConnexionController extends AbstractController
{
    public function index(Request $request, Response $response ,array $args = []): Response
    {
        if(isset($_SESSION['connexion'])){
            header("Location: /account");
            exit();
        }
        $response->getBody()->write($this->render('connexion'));
        return $response;
    }

    public function post(Request $request, Response $response, array $args = []):Response
    {
        if(isset($_SESSION['connexion'])){
            header("Location: /account");
            exit();
        }
        $info = $request->getParsedBody();
        $login = htmlspecialchars($info['login']);
        $pswd = htmlspecialchars($info['pswd']);

        $userRepo = $this->getEntityManager()->getRepository(User::class);
        $user = $userRepo->getUserByLogin($login);

        if (!empty($user)) {
            $salt = $user->getUserPasswdSalt();
            $calculatedPassword = hash('sha512', $pswd.$salt);
            if($calculatedPassword == $user->getUserPasswdHash()){
                $_SESSION['connexion'] = $user->getUserId();
                $this->account_type($user->getUserId());
            }
        }
        $response->getBody()->write($this->render('connexion', compact('login')));
        return $response;

    }

    public function account_type($id){
        $parent_rep = $this->getEntityManager()->getRepository(Parents::class);
        if(!empty($parent_rep->getParent($id))){
            $_SESSION['account_type'] = "user";
        }
        else{
            $staff_rep = $this->getEntityManager()->getRepository(Staff::class);
            if(!empty($staff_rep->getStaff($id))){
                $_SESSION['account_type'] = "staff";
            }
            else{
                header("Location: /connexion");
                exit();
            }
        }
    }

    public function deconnexion(Request $request, Response $response):Response
    {
        session_destroy();
        $response->getBody()->write($this->render('connexion'));
        return $response;

    }
}