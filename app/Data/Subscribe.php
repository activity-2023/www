<?php

namespace Data;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use \Repository\SubscribeRepository;

#[Entity(repositoryClass: \Repository\SubscribeRepository::class)]
#[Table(name: 'subscribe')]
class Subscribe{
    #[Id]
    #[Column(name: 'person_id', type: 'integer')]
    #[ManyToOne(targetEntity: Person::class, inversedBy: 'activitySubscribe')]
    private int $personId;

    #[Id]
    #[Column(name: 'activity_id', type: 'integer')]
    #[ManyToOne(targetEntity: Activity::class, inversedBy: 'subscribes')]
    private int $activityId;


    #[Column(name: 'suscription_date', type: 'date')]
    private \DateTime $suscriptionDate;



    public function __construct(int $personId, int $activityId)
    {
        $this->personId = $personId;
        $this->activityId = $activityId;
        $this->suscriptionDate = new \DateTime();
    }

    public function getSubsriptionDate(): \DateTime
    {
        return $this->suscriptionDate;
    }
    public function getPersonId(): int
    {
        return $this->personId;
    }

    public function getActivityId():int
    {
        return $this->activityId;
    }



}