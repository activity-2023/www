<?php

namespace App\Controller;

use Core\Controller\AbstractController;
use Data\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ConnexionController extends AbstractController
{
    public function index(Request $request, Response $response ,array $args = []): Response
    {
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
        $login = $info['login'];
        $pswd = $info['pswd'];
        $entityManager = $this->getEntityManager();

        $userRepo = $entityManager->getRepository(User::class);
        $user = $userRepo->getUserByLogin($login);

        if (!empty($user)) {
            $salt = $user->getUserPasswdSalt();
            $calculatedPassword = hash('sha512', $pswd.$salt);
            if($calculatedPassword == $user->getUserPasswdHash()){
                $_SESSION['connexion'] = $user->getUserId();
            }

        }

        $response->getBody()->write($this->render('connexion', compact('login')));
        return $response;

    }

    public function deconnexion(Request $request, Response $response):Response
    {
        session_destroy();
        $response->getBody()->write($this->render('connexion'));
        return $response;

    }
}