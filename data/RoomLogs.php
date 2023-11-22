<?php

namespace Data;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Repository\BuildingLogsRepository;
use \Repository\RoomLogsRepository;

#[Entity(repositoryClass: \Repository\RoomLogsRepository::class)]
#[Table(name: 'room_logs')]
class RoomLogs{

    #[Id]
    #[ManyToOne(targetEntity: Room::class, inversedBy: 'roomLogs')]
    #[Column(name: 'room_id', type: 'integer')]
    private int $roomId;

    #[Id]
    #[ManyToOne(targetEntity: Person::class, inversedBy: 'personLogsR')]
    #[Column(name: 'person_id', type: 'integer')]
    private int $personId;

    #[Column(name: 'rl_timestamp', type:'datetime')]
    private \DateTime $logDate;

    #[Column(name: 'rl_status', type:'boolean')]
    private bool $logStatus;

    public function __construct(int $roomId, int $personId){
        $this->personId = $personId;
        $this->roomId = $roomId;
    }
    public function getRoomId(): int
    {
        return $this->roomId;
    }

    public function getPersonId(): int
    {
        return $this->personId;
    }

    public function getLogDate()
    {
        return $this->logDate;
    }

    public function setLogDate($logDate): void
    {
        $this->logDate = $logDate;
    }

    public function getLogStatus()
    {
        return $this->logStatus;
    }

    public function setLogStatus($logStatus): void
    {
        $this->logStatus = $logStatus;
    }



}