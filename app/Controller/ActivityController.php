<?php

namespace App\Controller;

use Core\Controller\AbstractController;
use App\Data\Activity;
use App\Data\Event;
use App\Data\Organize;
use App\Data\Participate;
use App\Data\Propose;
use App\Data\Subscribe;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ActivityController extends AbstractController
{
    public function index(Request $request, Response $response, array $args = []): Response
    {
        $id = $args['id'];
        $entityManager = $this->getEntityManager();
        $events = $this->getAllEvents($id);
        $activityrep = $entityManager->getRepository(Activity::class);
        $activity_info = $this->getActivityInfo($activityrep->getActivity($id));
        $response->getBody()->write($this->render('activity', compact('activity_info', 'events')));
        return $response;
    }

    public function getAllEvents($activityId)
    {
        $queryB = $this->getEntityManager()->createQueryBuilder();
        $queryB->select('event')
            ->from(Event::class, 'event')
            ->where('event.activityId = :activityId')
            ->orderBy('event.eventDate', 'DESC')
            ->setParameter('activityId', $activityId)
            ->setMaxResults(6);
        return $queryB->getQuery()->getResult();
    }
    public function allreadyPropose($id_activity){
        $queryB = $this->getEntityManager()->createQueryBuilder();
        $queryB->select('propose')
            ->from(Propose::class, 'propose')
            ->where('propose.activityId = :activityId')
            ->andWhere('propose.staffId = :staffId')
            ->setParameter('activityId', $id_activity)
            ->setParameter('staffId', $_SESSION['connexion']);
        return $queryB->getQuery()->getResult();
    }

    public function allreadyOrganize($id_event){
        $queryB = $this->getEntityManager()->createQueryBuilder();
        $queryB->select('organize')
            ->from(Organize::class, 'organize')
            ->where('organize.eventId = :eventId')
            ->andWhere('organize.staffId = :staffId')
            ->setParameter('eventId', $id_event)
            ->setParameter('staffId', $_SESSION['connexion']);
        return $queryB->getQuery()->getResult();
    }

    public function allreadySubscribe($id_activity, $person_id){
        $queryB = $this->getEntityManager()->createQueryBuilder();
        $queryB->select('subscribe')
            ->from(Subscribe::class, 'subscribe')
            ->where('subscribe.activityId = :activityId')
            ->andWhere('subscribe.personId = :personId')
            ->setParameter('activityId', $id_activity)
            ->setParameter('personId', $person_id);
        return $queryB->getQuery()->getResult();
    }
    public function getEventInfo(Event $event):array
    {
        $activityRep =$this->getEntityManager()->getRepository(Activity::class);
        $activityName = $activityRep->getActivity($event->getActivityId())->getName();
        return [
            'id'=>$event->getEventId(),
            'date'=> $event->getEventDate()->format('Y-m-d'),
            'start_time'=>$event->getEventStartTime()->format('H:i'),
            'duration'=>$event->getEventDuration()->format('H:i'),
            'max_participant'=>$event->getEventMaxParticipant(),
            'activity_name'=>$activityName
        ];
    }
    public function getAllParticipants($eventId){

    }

}
