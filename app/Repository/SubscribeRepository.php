<?php

namespace App\Repository;

use App\Data\Subscribe;
use Doctrine\ORM\EntityRepository;

/**
 * @method Subscribe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subscribe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subscribe[] findAll()
 * @method Subscribe[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscribeRepository extends EntityRepository
{
    public function addSubscribtion(int $personId, int $activityId){
        $subscribe = new Subscribe($personId, $activityId);
        $this->getEntityManager()->persist($subscribe);
        $this->getEntityManager()->flush();
    }

    public function getSubscribtion(int $personId, int $activityId): Subscribe|null{
        return $this->findOneBy(['personId'=>$personId, 'activityId'=>$activityId]);
    }

    public function deleteSubscribtion(int $personId, int $activityId){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->delete(Subscribe::class, 's')
            ->where('s.activityId = :activityId')
            ->andWhere('s.personId = :personId')
            ->setParameter('personId', $personId)
            ->setParameter('activityId', $activityId);
        $qb->getQuery()->getResult();
    }
}
