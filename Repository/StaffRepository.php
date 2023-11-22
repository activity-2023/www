<?php

namespace Repository;

use Data\Enums\contractType;
use Data\Staff;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * @method Staff|null find($id, $lockMode = null, $lockVersion = null)
 * @method Staff|null findOneBy(array $criteria, array $orderBy = null)
 * @method Staff[] findAll()
 * @method Staff[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StaffRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
        Type::addType('contractType', 'Data\enums\contractType');
    }

    public function addStaff(int $staffId, string $email, string $phone, string $contractType){
        $staff = new Staff($staffId);
        $staff->setStaffEmail($email);
        $staff->setStaffPhone($phone);
        $staff->setStaffContractType((new contractType())->get($contractType));
        $this->getEntityManager()->persist($staff);
        $this->getEntityManager()->flush();
    }

    public function getStaff(int $staffId): Staff{
        return $this->find($staffId);
    }
}
