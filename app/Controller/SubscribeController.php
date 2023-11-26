<?php

namespace  App\Controller;

use Core\Controller\AbstractController;
use Data\Subscribe;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SubscribeController extends AbstractController{
    public function index(Request $request, Response $response, array $args = []): Response{
        if(!isset($_SESSION['connexion'])){
            header("Location: /account");
            exit();
        }
        $entityManager = $this->getEntityManager();
        $personId = $_SESSION['connexion'];
        $activityId = $args['id'];

        $subscribe = $entityManager->getRepository(Subscribe::class);
        $data = $subscribe->getSubscribtion($personId, $activityId);
        if(is_null($data)){
            $subscribe->addSubscribtion($personId, $activityId);
        }

        header("Location:/account");
        exit();
    }

}