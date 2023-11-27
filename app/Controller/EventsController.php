<?php

namespace  App\Controller;

use Core\Controller\AbstractController;
use App\Data\Building;
use App\Data\Event;
use App\Data\Participate;
use App\Data\Room;
use Doctrine\DBAL\Types\Type;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class EventsController extends AbstractController{
    public function index(Request $request, Response $response, array $args = []): Response{
        if(!isset($_SESSION['connexion']) || $_SESSION['account_type']!="staff"){
            header("Location: /connexion");
            exit();
        }
        $activityId = $args['id'];
        $activityName = $args['name'];
        $response->getBody()->write($this->render('eventcreation', compact('activityId',
            'activityName')));
        return $response;
    }

    public function post(Request $request, Response $response, array $args = []): Response{
        $info = $request->getParsedBody();
        $eventDate = new \DateTime($info['eventdate']);
        $eventStartTime = new \DateTime($info['startTime']);
        $eventduration = new \DateTime($info['duration']);
        $eventMaxParticipant = $info['maxParticipants'];

        $endTime = $this->calculEndTime($eventStartTime, $eventduration);
        $entityManager = $this->getEntityManager();

        Type::addType('roomType', 'App\Data\Enums\roomType');
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryb = $entityManager->createQueryBuilder();

        $queryBuilder->select('room')
            ->from(Event::class, 'event')
            ->join(Room::class, 'room', 'WITH', 'room.roomId = event.roomId')
            ->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq('event.eventDate', ':eventDate'),
                    $queryBuilder->expr()->gte('event.eventStartTime', ':startEvent'),
                    $queryBuilder->expr()->lte('event.eventStartTime', ':endEvent'),
                )
            )
            ->setParameter('eventDate', $eventDate)
            ->setParameter('startEvent', $eventStartTime)
            ->setParameter('endEvent', $endTime)
            ->setMaxResults(5);

        $queryb->select('r')
            ->from(Room::class, 'r')
            ->where(
                    $queryb->expr()->notIn('r.roomId', $queryBuilder->getDQL()),
                    $queryb->expr()->gte('r.roomCapacity', ':maxParticipants')
            )
            ->setParameter('eventDate', $eventDate)
            ->setParameter('startEvent', $eventStartTime)
            ->setParameter('endEvent', $endTime)
            ->setParameter('maxParticipants', $eventMaxParticipant)
            ->setMaxResults(5);

        $freeRoom = $queryb->getQuery()->getResult();
        $rooms = $this->getRoomInfo($freeRoom);

        $response->getBody()->write($this->render('roomChoice', compact('rooms','info')));
        return $response;
    }

    public function calculEndTime(\DateTime $startTime, \DateTime $duration): \DateTime{
        $dateref = new \DateTime('00:00:00');
        $newDateTime =  $startTime;
        return $newDateTime->add($dateref->diff($duration));
    }

    public function getRoomInfo($freeRooms){
        $info_rooms = array();
        foreach ($freeRooms as $room){
            $qb = $this->getEntityManager()->createQueryBuilder();
            $buildingquery = $qb->select('building')
                ->from(Building::class, 'building')
                ->where('building.buildingId = :idBuilding')
                ->setParameter('idBuilding', $room->getBuildingId())
                ->setMaxResults(1)
                ->getQuery();
            $building = $buildingquery->getArrayResult()[0];

            $room_info = [
                'id'=>$room->getBuildingId(),
                'name'=>$room->getRoomName(),
                'floor'=>$room->getRoomFloor(),
                'number'=>$room->getRoomNumber(),
                'type'=>$room->getRoomType(),
                'capacity'=>$room->getRoomCapacity(),
                'ad_st_num'=>$building['addressStreetNumber'],
                'ad_st_name'=>$building['addressStreetName'],
                'ad_zip'=>$building['addressZipCode'],
                'city'=>$building['addressCity'],
                'building_name'=>$building['buildingName'],
                'building_floors'=>$building['buildingNbFloors'],
                'building_has_elevator'=>$building['buildingHasElevator']
            ];
            $info_rooms[] = $room_info;
        }
        return $info_rooms;
    }

    public function inscription(Request $request, Response $response, array $args = []){
        if(!isset($_SESSION['connexion'])){
            header("Location: /connexion");
            exit();
        }
        $id_event = $args['id_event'];
        $id_person = $args['person_id'];

        $participateRep = $this->getEntityManager()->getRepository(Participate::class);
        $oldParticipation = $participateRep->getParticipation($id_person, $id_event);

        if(is_null($oldParticipation) && $this->nbfreePlaces($id_event) > 0){
            $participateRep->registerParticipant($id_person, $id_event);
        }
        header("Location: /account");
        exit();
    }

    public function personChoice(Request $request, Response $response, array $args = []):Response{
        $id_event = $args['id_event'];
        $persons = $this->getPersonsAccount($_SESSION['connexion']);
        $parent = $persons['parent'];
        $children = null;
        if(isset($persons['children'])){
            $children = $persons['children'];
        }
        $response->getBody()->write($this->render('personchoice', compact('id_event', 'parent', 'children')));
        return $response;
    }



    public function nbfreePlaces($event_id):int{
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('COUNT (participate.personId) as total')
            ->distinct()
            ->from(Participate::class, 'participate')
            ->where('participate.eventId = :eventId')
            ->groupBy('participate.eventId')
            ->setParameter('eventId', $event_id);
        $participations = $query->getQuery()->getResult()[0];

        if(is_null($participations)){
            $total = 0;
        }
        else{
            $total = $participations['total'];
        }
        $maxplaces = $this->getEntityManager()->getRepository(Event::class)->getEvent($event_id)->getEventMaxParticipant();
        return $maxplaces - $total;
    }

}
