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
    public function addEvent(int $activityId, int $roomId, \DateTime $date, \DateTime $startTime, \DateTime $duration, int $nbMax){
        $event = new Event();
        $event->setActivityId($activityId);
        $event->setRoomId($roomId);
        $event->setEventDuration($duration);
        $event->setEventDate($date);
        $event->setEventMaxParticipant($nbMax);
        $event->setEventStartTime($startTime);
        $this->getEntityManager()->persist($event);
        $this->getEntityManager()->flush();
    }

    public function getEvent(int $eventId): Event|null{
        return $this->find($eventId);
    }

}
