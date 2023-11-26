<?php

namespace App\Controller;

use Core\Controller\AbstractController;
use Data\Activity;
use Data\Event;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ActivityController extends AbstractController
{
    public function index(Request $request, Response $response, array $args = []): Response
    {
        $id = $args['id'];
        $entityManager = $this->getEntityManager();
        $events = $this->getAllEvents($entityManager, $id);
        $activityrep = $entityManager->getRepository(Activity::class);
        $activity_info = $this->getActivityInfo($activityrep->getActivity($id));
        $response->getBody()->write($this->render('activity', compact('activity_info', 'events')));

        return $response;
    }

    public function getAllEvents(EntityManager $entityManager, $activityId)
    {
        $queryB = $entityManager->createQueryBuilder();
        $queryB->select('event')
            ->from(Event::class, 'event')
            ->where('event.activityId = :activityId')
            ->orderBy('event.eventDate', 'DESC')
            ->setParameter('activityId', $activityId)
            ->setMaxResults(6);

        return $queryB->getQuery()->getResult();
    }

}
