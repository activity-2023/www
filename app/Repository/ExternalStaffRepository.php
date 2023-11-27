<?php

namespace App\Repository;

use App\Data\ExternalStaff;
use Doctrine\ORM\EntityRepository;

/**
 * @method ExternalStaff|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExternalStaff|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExternalStaff[] findAll()
 * @method ExternalStaff[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExternalStaffRepository extends EntityRepository
{
    public function addExternalStaff(int $exStaffId, string $origin, string $job){
        $externalStaff = new ExternalStaff($exStaffId);
        $externalStaff->setExStaffOrigin($origin);
        $externalStaff->setExStaffJob($job);
        $this->getEntityManager()->persist($externalStaff);
        $this->getEntityManager()->flush();
    }

    public function getExStaff(int $exStaffId): ExternalStaff|null{
        return $this->find($exStaffId);
    }
}
