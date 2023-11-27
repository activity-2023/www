<?php

namespace App\Data;

use App\Repository\ProposeRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: ProposeRepository::class)]
#[Table(name: 'propose')]
class Propose{

    #[Id]
    #[Column(name: 'activity_id', type: 'integer')]
    #[ManyToOne(targetEntity: Activity::class, inversedBy: 'proposition')]
    private int $activityId;

    #[Id]
    #[Column(name: 'staff_id', type: 'integer')]
    #[ManyToOne(targetEntity: Staff::class, inversedBy: 'proposition')]
    private int $staffId;

    public function __construct(int $staffId, int $activityId){
        $this->staffId = $staffId;
        $this->activityId = $activityId;

    }
    public function getActivityId(): int
    {
        return $this->activityId;
    }

    public function getStaffId(): int
    {
        return $this->staffId;
    }


}
