<?php

namespace Repository;

use Data\Participate;
use Doctrine\ORM\EntityRepository;

/**
 * @method Participate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participate[] findAll()
 * @method Participate[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipateRepository extends EntityRepository
{
    public function registerParticipant(int $personId, int $eventId){
        $participate = new Participate($personId, $eventId);
        $this->getEntityManager()->persist($participate);
        $this->getEntityManager()->flush();
    }

    public function getParticipation(int $personId, int $eventId): Participate|null{
        return $this->find(array("personId"=>$personId, "eventId"=>$eventId));
    }
}
