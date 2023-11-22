<?php

namespace App\Controller;

use Core\Controller\AbstractController;
use Core\DataBase\BdEntityManager;
use Data\Person;
use Data\User;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ConnexionController extends AbstractController
{
    public function index(Request $request, Response $response): Response
    {
        $response->getBody()->write($this->render('connexion'));
        return $response;
    }

    public function post(Request $request, Response $response):Response
    {
        $info = $request->getParsedBody();
        $login = $info['login'];
        $pswd = $info['pswd'];
        $conDataBase = new BdEntityManager();
        $entityManager = $conDataBase->initConnection();


        $personRepo = $entityManager->getRepository(Person::class);
        $user = $personRepo->getPersonByName('OULKADI');
        var_dump($user->getPersonFname());

        $userRepo = $entityManager->getRepository(User::class);
        $user = $userRepo->getUserByLogin('doulkadi');
        var_dump($user);
        //$userRepo->getUserByLogin($login);
        //$response->getBody()->write($this->render('connexion'));
        return $response;
    }
}