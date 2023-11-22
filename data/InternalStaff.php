<?php

namespace Data;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;
use \Repository\InternalStaffRepository;

#[Entity(repositoryClass: \Repository\InternalStaffRepository::class)]
#[Table(name: 'internal_staff')]
class InternalStaff{

    #[Id]
    #[Column(name: 'int_staff_id', type: 'integer')]
    #[OneToOne(targetEntity: Staff::class)]
    private int $intStaffId;

    #[Column(name: 'int_staff_hr_number', type: 'integer')]
    private int $intStaffHrNumber;

    #[Column(name: 'int_staff_function', type: 'staffFunction')]
    private $intStaffFunction;

    #[Column(name: 'address_street_number', type: 'integer')]
    private int $addressStreetNumber;

    #[Column(name: 'address_street_name', type: 'string')]
    private string $addressStreetName;

    #[Column(name: 'address_zip_code', type: 'string')]
    private string $addressZipCode;

    #[Column(name: 'address_city', type: 'string')]
    private string $addressCity;

    public function __construct(int $intStaffId){
        $this->intStaffId = $intStaffId;
    }

    public function getIntStaffId(): int
    {
        return $this->intStaffId;
    }

    public function getIntStaffHrNumber(): int
    {
        return $this->intStaffHrNumber;
    }

    public function setIntStaffHrNumber(int $intStaffHrNumber): void
    {
        $this->intStaffHrNumber = $intStaffHrNumber;
    }

    public function getIntStaffFunction()
    {
        return $this->intStaffFunction;
    }

    public function setIntStaffFunction($intStaffFunction): void
    {
        $this->intStaffFunction = $intStaffFunction;
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



}
