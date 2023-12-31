<?php

namespace App\Data;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use App\Repository\PersonRepository;

#[Entity(repositoryClass: PersonRepository::class)]
#[Table(name: 'person')]
class Person{
    #[Id]
    #[Column(name:'person_id')]
    #[GeneratedValue(strategy: 'IDENTITY')]
    private int $personId;
    #[Column(name:'person_fname')]
    private string $personFname;
    #[Column(name:'person_lname')]
    private string $personLname;
    #[Column(name:'person_gender', type: 'gender')]
    private $personGender;
    #[Column(name:'person_birth_date')]
    private  \DateTime $personBirthDate;

    #[Column(name: 'person_access_pin_hash', type: 'string')]
    private string $personAccessPinHash;

    public function getPersonAccessPinHash(): string
    {
        return $this->personAccessPinHash;
    }

    public function setPersonAccessPinHash(string $personAccessPinHash): void
    {
        $this->personAccessPinHash = $personAccessPinHash;
    }

    #[OneToMany(mappedBy: 'personId', targetEntity: BuildingLogs::class, cascade: ['remove'])]
    private Collection $personLogsB;

    #[OneToMany(mappedBy: 'personId', targetEntity: RoomLogs::class, cascade: ['remove'])]
    private Collection $personLogsR;

    #[OneToMany(mappedBy: 'personId', targetEntity: Participate::class, cascade: ['remove'])]
    private Collection $participation;

    #[OneToMany(mappedBy: 'personId', targetEntity: Subscribe::class, cascade: ['remove'])]
    private Collection $activitySubscribe;

    public function __construct(){
        $this->personLogsR = new ArrayCollection();
        $this->personLogsB = new ArrayCollection();
        $this->participation = new ArrayCollection();
        $this->activitySubscribe = new ArrayCollection();
    }
    public function getPersonId(): int{
        return $this->personId;
    }

    public function getPersonFname(): string{
        return $this->personFname;
    }

    public function setPersonFname(string $personFname): void{
        $this->personFname = $personFname;
    }

    public function getPersonLname(): string{
        return $this->personLname;
    }

    public function setPersonLname(string $personLname): void{
        $this->personLname = $personLname;
    }

    public function getPersonGender() {
        return $this->personGender;
    }

    public function setPersonGender( $personGender): void{
        $this->personGender = $personGender;
    }

    public function getPersonBirthDate(): \DateTime{
        return $this->personBirthDate;
    }

    public function setPersonBirthDate(\DateTime $personBirthDate): void{
        $this->personBirthDate = $personBirthDate;
    }


}
