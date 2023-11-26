<?php

namespace Repository;

use Data\Organize;
use Doctrine\ORM\EntityRepository;

/**
 * @method Organize|null find($id, $lockMode = null, $lockVersion = null)
 * @method Organize|null findOneBy(array $criteria, array $orderBy = null)
 * @method Organize[] findAll()
 * @method Organize[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganizeRepository extends EntityRepository
{
    public function organize(int $staffId, int $eventId){
        $organize = new Organize($staffId, $eventId);
        $this->getEntityManager()->persist($organize);
        $this->getEntityManager()->flush();
    }

    public function getOrganize(int $staffId, int $eventId): Organize|null{
        return $this->find(array("staffId"=>$staffId, "eventId"=>$eventId));
    }
    public function deleteOrganize(int $staffId, int $eventId){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->delete(Organize::class, 'o')
            ->where('o.eventId = :eventId')
            ->andWhere('o.staffId = :staffId')
            ->setParameter('staffId', $staffId)
            ->setParameter('eventId', $eventId);
        $qb->getQuery()->getResult();
    }

    public function getAllOrganize(int $eventId){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select( 'o')
            ->from(Organize::class, 'o')
            ->where('o.eventId = :eventId')
            ->setParameter('eventId', $eventId);
       return $qb->getQuery()->getResult();
    }
}
