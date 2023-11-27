<?php

namespace App\Repository;

use App\Data\BuildingLogs;
use Doctrine\ORM\EntityRepository;

/**
 * @method BuildingLogs|null find($id, $lockMode = null, $lockVersion = null)
 * @method BuildingLogs|null findOneBy(array $criteria, array $orderBy = null)
 * @method BuildingLogs[] findAll()
 * @method BuildingLogs[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuildingLogsRepository extends EntityRepository
{
    public function addLog(int $personId, int $buildingId, bool $status, \DateTime $dateTime){
        $buildinglog = new BuildingLogs($buildingId, $personId);
        $buildinglog->setLogStatus($status);
        $buildinglog->setLogDate($dateTime);
        $this->getEntityManager()->persist($buildinglog);
        $this->getEntityManager()->flush();
    }

    public function getBuildingLog(int $personId, int $buildingId): BuildingLogs|null{
        return $this->find(array("personId"=>$personId, "buildingId"=>$buildingId))?? null;
    }

}
