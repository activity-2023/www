<?php
namespace App\Controller;

use Core\Controller\AbstractController;
use App\Data\Event;
use App\Data\Organize;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RoomChoiceController extends AbstractController{
    public function index(Request $request, Response $response, array $args = []): Response{
        if(!isset($_SESSION['connexion']) || empty($args) || $_SESSION['account_type']!="staff"){
            header("Location: /connexion");
            exit();
        }
        $id_room = $args['room_id'];
        $event_start_time = $args['eventStartTime'];
        $event_date = $args['eventDate'];
        $event_duration =  $args['eventduration'];
        $event_max_participant = $args['eventMaxParticipant'];
        $id_activity = $args['activityId'];

        $entityManager = $this->getEntityManager();
        $eventrep = $entityManager->getRepository(Event::class);
        $event_id = $eventrep->addEvent( $id_activity, $id_room, $event_date, $event_start_time, $event_duration, $event_max_participant);
        $organizeReP = $entityManager->getRepository(Organize::class);
        if(empty($organizeReP->getOrganize($_SESSION['connexion'], $event_id))){
            $organizeReP->organize($_SESSION['connexion'], $event_id);
        }
        header("Location: /activity/id=".$id_activity);
        exit();

    }


}
