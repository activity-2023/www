<?php
namespace App\Controller;

use Core\Controller\AbstractController;
use Data\Activity;
use Data\Event;
use Data\Subscribe;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RoomChoiceController extends AbstractController{
    public function index(Request $request, Response $response, array $args = []): Response{
        if(!isset($_SESSION['connexion']) || empty($args)){
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
        $eventrep->addEvent( $id_activity, $id_room, $event_date, $event_start_time, $event_duration, $event_max_participant);

        header("Location: /activity/".$id_activity);
        exit();

    }

    public function getChildren(){

    }
    public function getAssociatedActivities(): array|null{
        $id = $_SESSION['connexion'];
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('A')
            ->from(Activity::class, 'A')
            ->join(Subscribe::class, 's', 'WITH', 'A.activityId = s.activityId')
            ->where('s.personId = :personId')
            ->orderBy('s.suscriptionDate', 'DESC')
            ->setParameter('personId',$id )
            ->setMaxResults( 4 );
        $query = $queryBuilder->getQuery();
        return $query->getResult();

    }

}
