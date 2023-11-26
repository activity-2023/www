<?php

namespace Data;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Repository\EventRepository;

#[Entity(repositoryClass: EventRepository::class)]
#[Table(name: 'event')]
class Event{
    #[Id]
    #[GeneratedValue(strategy: 'SEQUENCE')]
    #[Column(name: 'event_id', type: 'integer')]
    private int $eventId;

    #[Column(name: 'event_date', type: 'date')]
    private \DateTime $eventDate;

    #[Column(name: 'event_start_time', type: 'time')]
    private \DateTime $eventStartTime;

    #[Column(name: 'event_duration', type: 'time')]
    private \DateTime $eventDuration;

    #[Column(name: 'event_max_participants', type: 'integer')]
    private int $eventMaxParticipant;

    #[ManyToOne(targetEntity: Room::class, inversedBy: 'events')]
    #[Column(name: 'room_id', type: 'integer')]
    private int $roomId;

    #[ManyToOne(targetEntity: Activity::class, inversedBy: 'events')]
    #[Column(name: 'activity_id', type: 'integer')]
    private int $activityId;

    #[OneToMany(mappedBy: 'eventId', targetEntity: Participate::class)]
    private Collection $participation;

    #[OneToMany(mappedBy: 'eventId', targetEntity: Organize::class)]
    private Collection $organisation;

    #[OneToMany(mappedBy: 'eventId', targetEntity: Propose::class)]
    private Collection $proposition;

    public function __construct(){
        $this->participation = new ArrayCollection();
        $this->proposition = new ArrayCollection();
        $this->organisation = new ArrayCollection();
    }
    public function getEventId():int
    {
        return $this->eventId;
    }

    public function getEventDate(): \DateTime
    {
        return $this->eventDate;
    }

    public function getEventStartTime(): \DateTime
    {
        return $this->eventStartTime;
    }

    public function getEventDuration():  \DateTime
    {
        return $this->eventDuration;
    }

    public function getEventMaxParticipant():int
    {
        return $this->eventMaxParticipant;
    }

    public function getRoomId():int
    {
        return $this->roomId;
    }

    public function setRoomId(int $roomId): void
    {
        $this->roomId = $roomId;
    }

    public function setActivityId(int $activityId): void
    {
        $this->activityId = $activityId;
    }

    public function setEventDate($eventDate): void
    {
        $this->eventDate = $eventDate;
    }

    public function setEventStartTime($eventStartTime): void
    {
        $this->eventStartTime = $eventStartTime;
    }

    public function setEventDuration($eventDuration): void
    {
        $this->eventDuration = $eventDuration;
    }

    public function setEventMaxParticipant($eventMaxParticipant): void
    {
        $this->eventMaxParticipant = $eventMaxParticipant;
    }
    public function getActivityId():int
    {
        return $this->activityId;
    }

}
