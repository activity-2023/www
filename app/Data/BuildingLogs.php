<?php

namespace App\Data;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use App\Repository\BuildingLogsRepository;

#[Entity(repositoryClass: BuildingLogsRepository::class)]
#[Table(name: 'building_logs')]
class BuildingLogs{
    #[Id]
    #[ManyToOne(targetEntity: Person::class, inversedBy: 'personLogsB')]
    #[Column(name: 'person_id', type: 'integer')]
    private int $personId;

    #[Id]
    #[ManyToOne(targetEntity: Building::class, inversedBy:'buildingLogs')]
    #[Column(name: 'building_id', type:'integer')]
    private int $buildingId;

    #[Column(name: 'bl_timestamp', type:'datetime')]
    private  $logDate;

    #[Column(name: 'bl_status', type:'boolean')]
    private bool $logStatus;

    public function __construct(int $buildingId, int $personId){
        $this->buildingId = $buildingId;
        $this->personId = $personId;
    }

    public function getPersonId(): int
    {
        return $this->personId;
    }

    public function getBuildingId(): int
    {
        return $this->buildingId;
    }

    public function getLogDate()
    {
        return $this->logDate;
    }

    public function setLogDate($logDate): void
    {
        $this->logDate = $logDate;
    }

    public function getLogStatus(): bool
    {
        return $this->logStatus;
    }

    public function setLogStatus(bool $logStatus): void
    {
        $this->logStatus = $logStatus;
    }


}
