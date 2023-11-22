<?php

namespace Repository;

use Data\Enums\roomType;
use Data\Room;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * @method Room|null find($id, $lockMode = null, $lockVersion = null)
 * @method Room|null findOneBy(array $criteria, array $orderBy = null)
 * @method Room[] findAll()
 * @method Room[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
        Type::addType('roomType', 'Data\enums\roomType');
    }

    public function addRoom(string $name, int $floor, int $number, string $type, int $capacity, int $building_id){
        $room = new Room();
        $room->setRoomName($name);
        $room->setRoomNumber($number);
        $room->setRoomFloor($floor);
        $room->setRoomType((new roomType())->get($type));
        $room->setRoomCapacity($capacity);
        $room->setBuildingId($building_id);
        $this->getEntityManager()->persist($room);
        $this->getEntityManager()->flush();
    }

    public function getRoomWithId(int $id):Room{
        return $this->find($id);
    }

}
