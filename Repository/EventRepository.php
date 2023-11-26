<?php

namespace Repository;

use Cassandra\Time;
use Data\Event;
use Doctrine\DBAL\Types\TimeType;
use Doctrine\ORM\EntityRepository;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[] findAll()
 * @method Event[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends EntityRepository
{
    public function addEvent(int $activityId, int $roomId, string $date, string $startTime, string $duration, int $nbMax): int{
        $event = new Event();
        $event->setActivityId($activityId);
        $event->setRoomId($roomId);
        $event->setEventDuration(new \DateTime($duration));
        $event->setEventDate(new \DateTime($date));
        $event->setEventMaxParticipant($nbMax);
        $event->setEventStartTime(new \DateTime($startTime));
        $this->getEntityManager()->persist($event);
        $this->getEntityManager()->flush();
        return $event->getEventId();
    }

    public function getEvent(int $eventId): Event|null{
        return $this->find($eventId);
    }

    public function deleteEvent(int $eventId){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->delete(Event::class, 'e')
            ->where('e.eventId= :id')
            ->setParameter('id', $eventId);
        $qb->getQuery()->getResult();
    }

}
