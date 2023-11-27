<?php

namespace App\Data;

use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: ActivityRepository::class)]
#[Table(name: 'activity')]
class Activity {
    #[Id]
    #[Column(name: 'activity_id', type: 'integer')]
    #[GeneratedValue(strategy: "IDENTITY")]
    private int $activityId;

    #[Column(name: 'activity_name', type: 'string')]
    private string $name;

    #[Column(name: 'activity_description' , type: 'text')]
    private string $description;

    #[Column(name: 'activity_min_age', type: 'integer')]
    private int $minAge;

    #[Column(name: 'activity_price', type: 'float')]
    private float $price;

    #[OneToMany(mappedBy: 'activityId', targetEntity: Event::class, cascade: ['remove'])]
    private Collection $events;

    #[OneToMany(mappedBy: 'activityId', targetEntity: Subscribe::class, cascade: ['remove'])]
    private Collection $subscribes;

    #[OneToMany(mappedBy: 'activityId', targetEntity: Propose::class, cascade: ['remove'])]
    private Collection $proposition;

    public function __construct(){
        $this->events = new ArrayCollection();
        $this->subscribes = new ArrayCollection();
        $this->proposition = new ArrayCollection();
    }

    public function getActivityId(): int
    {
        return $this->activityId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getMinAge(): int
    {
        return $this->minAge;
    }

    public function setMinAge(int $minAge): void
    {
        $this->minAge = $minAge;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }



}
