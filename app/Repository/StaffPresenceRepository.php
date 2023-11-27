<?php

namespace App\Repository;

use App\Data\StaffPresence;
use Doctrine\ORM\EntityRepository;

/**
 * @method StaffPresence|null find($id, $lockMode = null, $lockVersion = null)
 * @method StaffPresence|null findOneBy(array $criteria, array $orderBy = null)
 * @method StaffPresence[] findAll()
 * @method StaffPresence[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StaffPresenceRepository extends EntityRepository
{
    public function addStaffPresence(int $staffId, \DateTime $date, \DateTime $startTime, \DateTime $endTime){
        $staffPresence = new StaffPresence($staffId);
        $staffPresence->setStaffPresDate($date);
        $staffPresence->setStaffStartTime($startTime);
        $this->getEntityManager()->persist($staffPresence);
        $this->getEntityManager()->flush();
    }
}
