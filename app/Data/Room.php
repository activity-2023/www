<?php

namespace App\Data;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use App\Repository\RoomRepository;

#[Entity(repositoryClass: RoomRepository::class)]
#[Table(name: 'room')]
class Room{
    #[Id]
    #[GeneratedValue(strategy: 'SEQUENCE')]
    #[Column(name: 'room_id', type: 'integer')]
    private int $roomId;

    #[Column(name: 'room_name', type: 'string')]
    private string $roomName;

    #[Column(name: 'room_floor', type: 'integer')]
    private int $roomFloor;

    #[Column(name: 'room_number', type: 'integer')]
    private int $roomNumber;

    #[Column(name: 'room_type', type: 'roomType')]
    private $roomType;

    #[Column(name: 'room_capacity', type: 'integer')]
    private int $roomCapacity;

    #[Column(name: 'building_id', type: 'integer')]
    #[ManyToOne(targetEntity: Building::class, inversedBy: 'rooms')]
    private int $buildingId;

    #[OneToMany(mappedBy: 'roomId', targetEntity: RoomLogs::class)]
    private Collection $roomLogs;

    #[OneToMany(mappedBy: 'roomId', targetEntity: Event::class)]
    private Collection $events;

    public function __construct()
    {
        $this->roomLogs = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    public function getRoomId():int
    {
        return $this->roomId;
    }

    public function getRoomName(): string
    {
        return $this->roomName;
    }

    public function setRoomName(string $roomName): void
    {
        $this->roomName = $roomName;
    }

    public function getRoomFloor(): int
    {
        return $this->roomFloor;
    }

    public function setRoomFloor(int $roomFloor): void
    {
        $this->roomFloor = $roomFloor;
    }

    public function getRoomNumber(): int
    {
        return $this->roomNumber;
    }

    public function setRoomNumber(int $roomNumber): void
    {
        $this->roomNumber = $roomNumber;
    }

    public function getRoomType()
    {
        return $this->roomType;
    }

    public function setRoomType($roomType): void
    {
        $this->roomType = $roomType;
    }

    public function getRoomCapacity(): int
    {
        return $this->roomCapacity;
    }

    public function setRoomCapacity(int $roomCapacity): void
    {
        $this->roomCapacity = $roomCapacity;
    }

    public function getBuildingId(): int
    {
        return $this->buildingId;
    }

    public function setBuildingId(int $buildingId): void
    {
        $this->buildingId = $buildingId;
    }


}
