<?php

namespace  App\Controller;

use Core\Controller\AbstractController;
use Data\Activity;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ActivitiesController extends AbstractController
{
    public function index(Request $request, Response $response, array $args = []): Response
    {
        $entityManager = $this->getEntityManager();

        $activityRep = $entityManager->getRepository(Activity::class);
        $activities = $activityRep->getAllActivities();

        $response->getBody()->write($this->render('activities', compact('activities')));
        return $response;
    }

    public function activityAdd(Request $request, Response $response, array $args = []){
        if(!isset($_SESSION['connexion'])){
            header("Location: /connexion");
            exit();
        }
        $info = $request->getParsedBody();
        $activity_info = [
            'name'=>$info['name'],
            'description'=>$info['description'],
            'minAge'=>intval($info['minAge']),
            'price'=>floatval($info['price'])
        ];
        $entityManager = $this->getEntityManager();

        $activityRep = $entityManager->getRepository(Activity::class);
        $activityRep->addActivity($activity_info['name'], $activity_info['description'],
        $activity_info['minAge'], $activity_info['price']);
        $activities = $activityRep->getAllActivities();
        $response->getBody()->write($this->render('activities', compact('activities') ));
        return $response;
    }

    public function createActivity(Request $request, Response $response){
        if(!isset($_SESSION['connexion'])){
            header("Location: /connexion");
            exit();
        }
        $response->getBody()->write($this->render('activitycreation' ));
        return $response;
    }




}