<?php

namespace Data;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use \Repository\OrganizeRepository;

#[Entity(repositoryClass: \Repository\OrganizeRepository::class)]
#[Table(name: 'organize')]
class Organize{

    #[Id]
    #[Column(name: 'staff_id', type: 'integer')]
    #[ManyToOne(targetEntity: Staff::class, inversedBy: 'organisation')]
    private int $staffId;

    #[Id]
    #[Column(name: 'event_id', type: 'integer')]
    #[ManyToOne(targetEntity: Event::class, inversedBy: 'organisation')]
    private int $eventId;

    public function __construct(int $staffId, int $eventId){
        $this->eventId = $eventId;
        $this->staffId = $staffId;
    }

    public function getStaffId(): int
    {
        return $this->staffId;
    }

    public function getEventId(): int
    {
        return $this->eventId;
    }

}
