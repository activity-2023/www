<?php

namespace repository;

use Data\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[] findAll()
 * @method User[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
    }

    public function addUser(int $id, string $login, string $pwsd){
        $user = new User($id);
        $user->setUserLogin($login);
        $salt = $this->generateRandomSalt();
        $hash = hash('sha512', $pwsd.$salt);
        $user->setUserPasswdHash($hash);
        $user->setUserPasswdSalt($salt);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function getUserByLogin(string $login):User|null{
        return $this->findOneBy(['userLogin'=>$login]);
    }

    public function getUserById($idUser):User|null{
        return $this->find($idUser);
    }

    public function generateRandomSalt(){
        $alph = ['a','z','e','r','t','y','u','i','o','p','q',
            's','d','f','g','h','j','k','l','m','w','x','c','v','b','n'];
        $salt = '';
        for($i =0; $i <10; $i++){
            $index = rand(0,25);
            $salt.=$alph[$index];
        }
        return $salt;
    }

}
