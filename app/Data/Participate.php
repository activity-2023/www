<?php

namespace Data;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use \Repository\ParticipateRepository;

#[Entity(repositoryClass: \Repository\ParticipateRepository::class)]
#[Table(name: 'participate')]
class Participate{

    #[Id]
    #[Column(name: 'person_id', type: 'integer')]
    #[ManyToOne(targetEntity: Person::class, inversedBy: 'participation')]
    private int $personId;

    #[Id]
    #[Column(name: 'event_id', type: 'integer')]
    #[ManyToOne(targetEntity: Event::class, inversedBy: 'participation')]
    private int $eventId;

    public function __construct(int $personId, int $eventId){
        $this->eventId = $eventId;
        $this->personId = $personId;
    }
    public function getPersonId(): int
    {
        return $this->personId;
    }

    public function getEventId(): int
    {
        return $this->eventId;
    }

}
