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
use \Repository\ParentsRepository;

#[Entity(repositoryClass: \Repository\ParentsRepository::class)]
#[Table(name: 'parent')]
class Parents{

    #[Id]
    #[Column(name: 'parent_id', type: 'integer')]
    #[OneToOne(targetEntity: User::class)]
    private int $parentId;

    #[Column(name: 'parent_email', type: 'string')]
    private string $parentEmail;

    #[Column(name: 'parent_phone', type: 'string')]
    private string $parentPhone;

    #[Column(name: 'parent_job', type: 'string', nullable: 'true')]
    private string $parentJob;

    #[Column(name: 'address_street_number', type: 'integer')]
    private int $addressStreetNumber;

    #[Column(name: 'address_street_name', type: 'string')]
    private string $addressStreetName;

    #[Column(name: 'address_zip_code', type: 'string')]
    private string $addressZipCode;

    #[Column(name: 'address_city', type: 'string')]
    private string $addressCity;

    #[OneToMany(mappedBy: 'parentId', targetEntity: Child::class)]
    private Collection $children;

    public function __construct($parentId){
        $this->parentId = $parentId;
        $this->children = new ArrayCollection();
    }
    public function getAddressStreetNumber(): int
    {
        return $this->addressStreetNumber;
    }

    public function setAddressStreetNumber(int $addressStreetNumber): void
    {
        $this->addressStreetNumber = $addressStreetNumber;
    }

    public function getAddressStreetName(): string
    {
        return $this->addressStreetName;
    }

    public function setAddressStreetName(string $addressStreetName): void
    {
        $this->addressStreetName = $addressStreetName;
    }

    public function getAddressZipCode(): string
    {
        return $this->addressZipCode;
    }

    public function setAddressZipCode(string $addressZipCode): void
    {
        $this->addressZipCode = $addressZipCode;
    }

    public function getAddressCity(): string
    {
        return $this->addressCity;
    }

    public function setAddressCity(string $addressCity): void
    {
        $this->addressCity = $addressCity;
    }

    public function getParentId():int
    {
        return $this->parentId;
    }

    public function getParentEmail(): string
    {
        return $this->parentEmail;
    }

    public function setParentEmail(string $parentEmail): void
    {
        $this->parentEmail = $parentEmail;
    }

    public function getParentPhone():string
    {
        return $this->parentPhone;
    }

    public function setParentPhone(string $parentPhone): void
    {
        $this->parentPhone = $parentPhone;
    }

    public function getParentJob():string
    {
        return $this->parentJob;
    }

    public function setParentJob($parentJob): void
    {
        $this->parentJob = $parentJob;
    }



}
