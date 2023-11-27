<?php

namespace repository;

use Data\Child;
use Data\Enums\schoolLevel;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * @method Child|null find($id, $lockMode = null, $lockVersion = null)
 * @method Child|null findOneBy(array $criteria, array $orderBy = null)
 * @method Child[] findAll()
 * @method Child[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChildRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
        Type::addType('schoolLevel', 'Data\enums\schoolLevel');
    }
    public function addChild(int $childId, int $parentId, string $schoolLevel = null){
        $child = new Child($childId);
        $child->setChildSchoolLevel((new schoolLevel())->get($schoolLevel));
        $child->setParentId($parentId);
        $this->getEntityManager()->persist($child);
        $this->getEntityManager()->flush();

    }
    public function getChild(int $id): Child|null{
        return $this->find($id);
    }

    public function getChildrenByParentId(int $parentId){
        $queryB = $this->getEntityManager()->createQueryBuilder();
        $queryB->select('child')
            ->from(Child::class, 'child')
            ->where('child.parentId = :parentId')
            ->setParameter('parentId', $parentId);
        return $queryB->getQuery()->getArrayResult();
    }

    public function deleteChild(int $id){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->delete(Child::class, 'c')
            ->where('c.childId= :id')
            ->setParameter('id', $id);
        $qb->getQuery()->getResult();
    }
}
