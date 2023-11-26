<?php

namespace App\Controller;

use Core\Controller\AbstractController;
use Data\Organize;

use Data\Propose;
use Data\Staff;
use Data\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class StaffFonctionController extends AbstractController
{
    public function index(Request $request, Response $response, array $args = []): Response
    {
        $account_type = 'user';
        $response->getBody()->write($this->render('register', compact('account_type')));
        return $response;
    }
    public function staff(Request $request, Response $response, array $args = []): Response
    {
        $account_type = 'staff';
        $response->getBody()->write($this->render('register', compact('account_type')));
        return $response;
    }

    public function joinActivity(Request $request, Response $response, array $args = []): Response
    {
        if(!isset($_SESSION['connexion']) || $_SESSION['account_type']!="staff" ){
            header("Location: /connexion");
            exit();
        }
        $activity_id = $args['id'];
        $proposeRep = $this->getEntityManager()->getRepository(Propose::class);
        $oldProposition = $proposeRep->getProposition($_SESSION['connexion'], $activity_id);
        if(empty($oldProposition)){
            $proposeRep->propose($_SESSION['connexion'], $activity_id);
        }
        header("Location: /account");
        exit();
    }
    public function joinEvent(Request $request, Response $response, array $args = []): Response
    {
        if(!isset($_SESSION['connexion']) || $_SESSION['account_type']!="staff" ){
            header("Location: /connexion");
            exit();
        }
        $event_id= $args['id'];
        $organizeRep = $this->getEntityManager()->getRepository(Organize::class);
        $oldProposition = $organizeRep->getOrganize($_SESSION['connexion'], $event_id);
        if(empty($oldProposition)){
            $organizeRep->organize($_SESSION['connexion'], $event_id);
        }
        header("Location: /account");
        exit();
    }
}
