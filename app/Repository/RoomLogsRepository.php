<?php

namespace repository;

use Data\RoomLogs;
use Doctrine\ORM\EntityRepository;

/**
 * @method RoomLogs|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoomLogs|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoomLogs[] findAll()
 * @method RoomLogs[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomLogsRepository extends EntityRepository
{
    public function addLog(int $personId, int $roomId, bool $status){
        $log = new RoomLogs($roomId, $personId);
        $log->setLogDate(new \DateTime());
        $log->setLogStatus($status);
        $this->getEntityManager()->persist($log);
        $this->getEntityManager()->flush();
    }

    public function getRoomLog(int $personId, int $roomId): RoomLogs|null{
        return  $this->find(array("personId"=>$personId, "roomId"=>$roomId))?? null;
    }
}
