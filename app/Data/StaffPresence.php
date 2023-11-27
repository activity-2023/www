<?php

namespace App\Data;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use App\Repository\StaffPresenceRepository;

#[Entity(repositoryClass: StaffPresenceRepository::class)]
#[Table(name: 'staff_presence')]
class StaffPresence{

    #[Id]
    #[GeneratedValue(strategy: 'SEQUENCE')]
    #[Column(name: 'staff_pres_id', type: 'integer')]
    private int $staffPresId;

    #[Column(name: 'staff_pres_date', type: 'date')]
    private $staffPresDate;

    #[Column(name: 'staff_pres_start_time', type :'time')]
    private $staffStartTime;

    #[Column(name: 'staff_pres_duration',type: 'time')]
    private $staffPresDuration;

    #[Column(name: 'staff_id', type: 'integer')]
    #[ManyToOne(targetEntity: Staff::class, inversedBy: 'staffPresence')]
    private int $staffId;

    public function __construct(int $staffId){
        $this->staffId = $staffId;
    }

    public function getStaffPresDuration()
    {
        return $this->staffPresDuration;
    }

    public function setStaffPresDuration($staffPresDuration): void
    {
        $this->staffPresDuration = $staffPresDuration;
    }

    public function getStaffPresId():int
    {
        return $this->staffPresId;
    }

    public function getStaffPresDate()
    {
        return $this->staffPresDate;
    }

    public function setStaffPresDate($staffPresDate): void
    {
        $this->staffPresDate = $staffPresDate;
    }

    public function getStaffStartTime()
    {
        return $this->staffStartTime;
    }

    public function setStaffStartTime($staffStartTime): void
    {
        $this->staffStartTime = $staffStartTime;
    }




}