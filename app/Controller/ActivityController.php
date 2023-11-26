<?php

namespace App\Controller;

use Core\Controller\AbstractController;
use Data\Activity;
use Data\Event;
use Data\Organize;
use Data\Participate;
use Data\Propose;
use Data\Subscribe;
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
    public function allreadyParticipate($id_event, $person_id){
        $queryB = $this->getEntityManager()->createQueryBuilder();
        $queryB->select('participate')
            ->from(Participate::class, 'participate')
            ->where('participate.eventId = :eventId')
            ->andWhere('participate.personId = :personId')
            ->setParameter('eventId', $id_event)
            ->setParameter('personId', $person_id);
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


}
