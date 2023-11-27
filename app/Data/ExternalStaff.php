<?php

namespace App\Data;

use App\Repository\ExternalStaffRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: ExternalStaffRepository::class)]
#[Table(name: 'external_staff')]
class ExternalStaff{

    #[Id]
    #[Column(name: 'ex_staff_id', type: 'integer')]
    #[OneToOne(targetEntity: Staff::class)]
    private int $exStaffId;

    #[Column(name: 'ex_staff_origin', type: 'string')]
    private string $exStaffOrigin;

    #[Column(name: 'ex_staff_job', type: 'string')]
    private string $exStaffJob;

    public function __construct(int $exStaffId){
        $this->exStaffId = $exStaffId;
    }
    public function getExStaffId(): int
    {
        return $this->exStaffId;
    }

    public function getExStaffOrigin(): int
    {
        return $this->exStaffOrigin;
    }

    public function setExStaffOrigin($exStaffOrigin): void
    {
        $this->exStaffOrigin = $exStaffOrigin;
    }

    public function getExStaffJob(): string
    {
        return $this->exStaffJob;
    }

    public function setExStaffJob($exStaffJob): void
    {
        $this->exStaffJob = $exStaffJob;
    }



}
