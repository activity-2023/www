<?php

namespace Data;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;
use \Repository\StaffRepository;

#[Entity(repositoryClass: StaffRepository::class)]
#[Table(name: 'staff')]
class Staff{
    #[Id]
    #[Column(name: 'staff_id', type: 'integer')]
    #[OneToOne(targetEntity: User::class)]
    private int $staffId;

    #[Column(name: 'staff_email', type: 'string')]
    private string $staffEmail;

    #[Column(name: 'staff_phone', type: 'string')]
    private string $staffPhone;

    #[Column(name: 'staff_contract_type', type: 'contractType')]
    private $staffContractType;

    #[OneToMany(mappedBy: 'staffId', targetEntity: StaffPresence::class)]
    private Collection $staffPresence;


    #[OneToMany(mappedBy: 'staffId', targetEntity: Organize::class)]
    private Collection $organisation;

    #[OneToMany(mappedBy: 'staffId', targetEntity: Propose::class)]
    private Collection $proposition;

    public function __construct(int $staffId)
    {
        $this->staffId = $staffId;
        $this->staffPresence = new ArrayCollection();
        $this->organisation = new ArrayCollection();
        $this->proposition = new ArrayCollection();
    }

    public function getStaffId(): int
    {
        return $this->staffId;
    }

    public function getStaffEmail():string
    {
        return $this->staffEmail;
    }

    public function setStaffEmail($staffEmail): void
    {
        $this->staffEmail = $staffEmail;
    }

    public function getStaffPhone():string
    {
        return $this->staffPhone;
    }

    public function setStaffPhone($staffPhone): void
    {
        $this->staffPhone = $staffPhone;
    }

    public function getStaffContractType()
    {
        return $this->staffContractType;
    }

    public function setStaffContractType($staffContractType): void
    {
        $this->staffContractType = $staffContractType;
    }

}
