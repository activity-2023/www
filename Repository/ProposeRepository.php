<?php

namespace Repository;

use Data\Propose;
use Doctrine\ORM\EntityRepository;

/**
 * @method Propose|null find($id, $lockMode = null, $lockVersion = null)
 * @method Propose|null findOneBy(array $criteria, array $orderBy = null)
 * @method Propose[] findAll()
 * @method Propose[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProposeRepository extends EntityRepository
{
    public function propose(int $staffId, int $activityId){
        $pro = new Propose($staffId, $activityId);
        $this->getEntityManager()->persist($pro);
        $this->getEntityManager()->flush();
    }

    public function getProposition(int $staffId, int $activityId): Propose|null{
        return $this->find(array("staffId"=>$staffId, "activityId"=>$activityId));
    }

    public function deleteProposition(int $staffId, int $activityId){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->delete(Propose::class, 'p')
            ->where('p.activityId = :activityId')
            ->andWhere('p.staffId = :staffId')
            ->setParameter('staffId', $staffId)
            ->setParameter('activityId', $activityId);
        $qb->getQuery()->getResult();
    }
}
