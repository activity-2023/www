<?php

namespace Repository;

use Data\InternalStaff;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * @method InternalStaff|null find($id, $lockMode = null, $lockVersion = null)
 * @method InternalStaff|null findOneBy(array $criteria, array $orderBy = null)
 * @method InternalStaff[] findAll()
 * @method InternalStaff[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InternalStaffRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
        Type::addType('staffFunction', 'Data\enums\staffFunction');

    }

    public function addInternalStaff(int $intStaffId, int $intHrNumber, string $staffFunction,
                                     int $streetNumber, string $streetName, string $zipCode, string $city){
        $intStaff = new InternalStaff($intStaffId);
        $intStaff->setIntStaffHrNumber($intHrNumber);
        $intStaff->setIntStaffFunction($staffFunction);
        $intStaff->setAddressStreetNumber($streetNumber);
        $intStaff->setAddressStreetName($streetName);
        $intStaff->setAddressZipCode($zipCode);
        $intStaff->setAddressCity($city);

        $this->getEntityManager()->persist($intStaff);
        $this->getEntityManager()->flush();
    }

    public function getInternalStaff(int $intStaffId): InternalStaff|null{
        return $this->find($intStaffId);
    }
    public function getInternalStaffByHrNumber(int $hr){
        $queryb = $this->getEntityManager()->createQueryBuilder();
        $queryb->select('staff')
            ->from(InternalStaff::class, 'staff')
            ->where('staff.intStaffHrNumber = :hr')
            ->setParameter('hr', $hr);
        return $queryb->getQuery()->getResult();
    }
}
