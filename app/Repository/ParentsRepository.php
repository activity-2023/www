<?php

namespace repository;

use Data\Parents;
use Doctrine\ORM\EntityRepository;

/**
 * @method Parents|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parents|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parents[] findAll()
 * @method Parents[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParentsRepository extends EntityRepository
{
    public function addParent(int $parentId, string $email, string $phone, int $addressStreetNumber,
                              string $addressStreetName, string $addressZipCode, string $addressCity, string $job = null){
        $parent = new Parents($parentId);
        $parent->setParentEmail($email);
        $parent->setParentJob($job);
        $parent->setParentPhone($phone);
        $parent->setAddressStreetNumber($addressStreetNumber);
        $parent->setAddressStreetName($addressStreetName);
        $parent->setAddressZipCode($addressZipCode);
        $parent->setAddressCity($addressCity);
        $this->getEntityManager()->persist($parent);
        $this->getEntityManager()->flush();
    }
    public function getParent(int $parentId):Parents|null{
        return $this->find($parentId);
    }
}
