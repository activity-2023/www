<?php

namespace App\Data;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use App\Repository\SubscribeRepository;

#[Entity(repositoryClass: SubscribeRepository::class)]
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



    public function __construct(int $personId, int $activityId)
    {
        $this->personId = $personId;
        $this->activityId = $activityId;
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