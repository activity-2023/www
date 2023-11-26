<?php

namespace Repository;

use Data\Enums\gender;
use Data\Person;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * @method Person|null find($id, $lockMode = null, $lockVersion = null)
 * @method Person|null findOneBy(array $criteria, array $orderBy = null)
 * @method Person[] findAll()
 * @method Person[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
        Type::addType('gender', 'Data\enums\gender');
    }

    public function addPerson(string $fname, string $lname, string $gender, \DateTime $birthDate, string $pin): int{
        $person = new Person();
        $person->setPersonFname($fname);
        $person->setPersonLname($lname);
        $person->setPersonGender((new gender())->get($gender));
        $person->setPersonBirthDate($birthDate);
        $pinHash = hash('sha256', $pin);
        $person->setPersonAccessPinHash($pinHash);
        $this->getEntityManager()->persist($person);
        $this->getEntityManager()->flush();
        return $person->getPersonId();
    }

    public function getPerson(int $personId):Person|null{
        return $this->find($personId);
    }

    public function getPersonByName(string $name):Person|null{
        return $this->findOneBy(['personLname'=>$name]);
    }
}
