<?php

namespace Data;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\BooleanType;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Psr\Log\NullLogger;
use Repository\BuildingRepository;

#[Entity(repositoryClass: BuildingRepository::class)]
#[Table(name: 'building')]
class Building{
    #[Id]
    #[Column(name: 'building_id', type: 'integer')]
    #[GeneratedValue(strategy: 'SEQUENCE')]
    private int $buildingId;

    #[Column(name: 'building_name', type:'string')]
    private string $buildingName;

    #[Column(name: 'address_street_number', type: 'integer')]
    private int $addressStreetNumber;

    #[Column(name: 'address_street_name', type: 'string')]
    private string $addressStreetName;

    #[Column(name: 'address_zip_code', type: 'string')]
    private string $addressZipCode;

    #[Column(name: 'address_city', type: 'string')]
    private string $addressCity;

    #[Column(name: 'building_nb_floors', type: 'integer')]
    private int $buildingNbFloors;

    #[Column(name: 'building_has_elevator', type: 'boolean')]
    private bool $buildingHasElevator;

    #[OneToMany(mappedBy: 'buildingId', targetEntity: Room::class)]
    private Collection $rooms;

    #[OneToMany(mappedBy: 'buildingId', targetEntity: BuildingLogs::class)]
    private Collection $buildingLogs;

    public function __construct(){
        $this->buildingLogs = new ArrayCollection();
        $this->rooms = new ArrayCollection();
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

    public function getRooms(): Collection
    {
        return $this->rooms;
    }
    public function addRoom(Room $room): void
    {
        $this->rooms->add($room);
    }
    public function getRoom(int $nb): Room|null{
        if(in_array($nb, (array)$this->rooms)){
            return $this->rooms->get($nb);
        }
        return null;
    }

    public function getBuildingId(): int{
        return $this->buildingId;
    }

    public function getBuildingName(): string{
        return $this->buildingName;
    }

    public function setBuildingName($buildingName): void{
        $this->buildingName = $buildingName;
    }

    public function getBuildingNbFloors():string{
        return $this->buildingNbFloors;
    }

    public function setBuildingNbFloors($buildingNbFloors): void{
        $this->buildingNbFloors = $buildingNbFloors;
    }

    public function getBuildingHasElevator():string{
        return $this->buildingHasElevator;
    }

    public function setBuildingHasElevator($buildingHasElevator): void{
        $this->buildingHasElevator = $buildingHasElevator;
    }

}
