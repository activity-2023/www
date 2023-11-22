<?php

namespace Data;

use Data\Enums\schoolLevel;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;
use \Repository\ChildRepository;

#[Entity(repositoryClass: \Repository\ChildRepository::class)]
#[Table(name: 'child')]
class Child  {
    #[Id]
    #[Column(name: 'child_id', type: 'integer')]
    #[OneToOne(targetEntity: Person::class)]
    private int $childId;

    #[Column(name: 'child_school_level', type: 'schoolLevel' ,nullable: 'true')]
    private $childSchoolLevel;

    #[Column(name: 'parent_id', type: 'integer')]
    #[ManyToOne(targetEntity: Parents::class, inversedBy: 'children')]
    private int $parentId;

    public function __construct(int $childId){
        $this->childId = $childId;
    }
    public function getParentId():int
    {
        return $this->parentId;
    }

    public function setParentId($parentId): void
    {
        $this->parentId = $parentId;
    }


    public function getChildId():int
    {
        return $this->childId;
    }

    public function getChildSchoolLevel(): schoolLevel
    {
        return $this->childSchoolLevel;
    }

    public function setChildSchoolLevel($childSchoolLevel): void
    {
        $this->childSchoolLevel = $childSchoolLevel;
    }

}