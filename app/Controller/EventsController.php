<?php

namespace  App\Controller;

use Core\Controller\AbstractController;
use Data\Building;
use Data\Event;
use Data\Participate;
use Data\Room;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class EventsController extends AbstractController{
    public function index(Request $request, Response $response, array $args = []): Response{
        $activityId = $args['id'];
        $response->getBody()->write($this->render('eventcreation', compact('activityId')));
        return $response;
    }

    public function post(Request $request, Response $response, array $args = []): Response{
        $info = $request->getParsedBody();
        $activityId = $info['activityId'];
        $eventDate = new \DateTime($info['eventdate']);
        $eventStartTime = new \DateTime($info['startTime']);
        $eventduration = new \DateTime($info['duration']);
        $eventMaxParticipant = $info['maxParticipants'];

        $endTime = $this->calculEndTime($eventStartTime, $eventduration);

        $entityManager = $this->getEntityManager();

        Type::addType('roomType', 'Data\enums\roomType');
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryb = $entityManager->createQueryBuilder();

        // toute les room occupées
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
        $rooms = $this->getRoomInfo($freeRoom, $entityManager);

        $response->getBody()->write($this->render('roomChoice', compact('rooms','info')));
        return $response;
    }

    public function calculEndTime(\DateTime $startTime, \DateTime $duration): \DateTime{
        $dateref = new \DateTime('00:00:00');
        $newDateTime = clone $startTime;
        return $newDateTime->add($dateref->diff($duration));
    }

    public function getRoomInfo($freeRooms,EntityManager $entityManager){
        $info_rooms = array();
        foreach ($freeRooms as $room){
            $qb = $entityManager->createQueryBuilder();
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
        $id_person = $_SESSION['connexion'];

        $entityManager = $this->getEntityManager();
        $participateRep = $entityManager->getRepository(Participate::class);
        $oldParticipation = $participateRep->getParticipation($id_person, $id_event);

        if(is_null($oldParticipation)   && $this->nbfreePlaces($id_event, $entityManager) > 0){
            $participateRep->registerParticipant($id_person, $id_event);
        }
        header("Location: /account");
        exit();
    }

    public function nbfreePlaces($event_id, EntityManager $entityManager):int{
        $query = $entityManager->createQueryBuilder();
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
        $maxplaces = $entityManager->getRepository(Event::class)->getEvent($event_id)->getEventMaxParticipant();
        return $maxplaces - $total;
    }


}
