<?php

namespace App\Controller;

use Core\Controller\AbstractController;
use App\Data\Event;
use App\Data\Organize;
use App\Data\Participate;
use App\Data\Propose;
use App\Data\Subscribe;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CancelController extends AbstractController
{
    public function index(Request $request, Response $response, array $args = []): Response
    {
        $id_event = $args['id'];
        $organizeRep = $this->getEntityManager()->getRepository(Organize::class);
        if(!empty($organizeRep->getOrganize($_SESSION['connexion'], $id_event))){
            $organizeRep->deleteOrganize($_SESSION['connexion'], $id_event);
        }
        if(empty($organizeRep->getAllOrganize($id_event))){
            $eventRep = $this->getEntityManager()->getRepository(Event::class);
            $eventRep->deleteEvent($id_event);
        }
        header("Location: /account");
        exit();
    }

    public function cancel_activity(Request $request, Response $response, array $args = []): Response{
        $id_activity = $args['id'];
        $proposeRep = $this->getEntityManager()->getRepository(Propose::class);
        if(!empty($proposeRep->getProposition($_SESSION['connexion'], $id_activity))){
            $proposeRep->deleteProposition($_SESSION['connexion'], $id_activity);
        }
        header("Location: /account");
        exit();
    }
    public function unsubscribe_event(Request $request, Response $response, array $args = []): Response{
        $id_event = $args['id'];
        $personId = $args['personId'];
        $participateRep = $this->getEntityManager()->getRepository(Participate::class);
        if(!empty($participateRep->getParticipation($personId, $id_event))){
            $participateRep->deleteParticipation($personId, $id_event);
        }
        header("Location: /account");
        exit();
    }

    public function unsubscribe_activity(Request $request, Response $response, array $args = []): Response{
        $id_activity = $args['id'];
        $participateRep = $this->getEntityManager()->getRepository(Subscribe::class);
        if(!empty($participateRep->getSubscribtion($_SESSION['connexion'], $id_activity))){
            $participateRep->deleteSubscribtion($_SESSION['connexion'], $id_activity);
        }
        header("Location: /account");
        exit();
    }


}
