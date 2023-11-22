<?php

namespace Data;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;
use \Repository\UserRepository;

#[Entity(repositoryClass: UserRepository::class)]
#[Table(name: 'user')]
class User {
    #[Id]
    #[Column(name: 'user_id', type: 'integer')]
    #[OneToOne(targetEntity: Person::class)]
    private int $userId;
    #[Column(name: 'user_login', type: 'string')]
    private string $userLogin;
    #[Column(name: 'user_passwd_hash', type: 'string')]
    private string $userPasswdHash;

    #[Column(name: 'user_passwd_salt', type: 'string')]
    private string $userPasswdSalt;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId():int
    {
        return $this->userId;
    }

    public function getUserLogin(): string
    {
        return $this->userLogin;
    }

    public function setUserLogin($userLogin): void
    {
        $this->userLogin = $userLogin;
    }

    public function getUserPasswdHash(): string
    {
        return $this->userPasswdHash;
    }

    public function setUserPasswdHash($userPasswdHash): void
    {
        $this->userPasswdHash = $userPasswdHash;
    }

    public function getUserPasswdSalt(): string
    {
        return $this->userPasswdSalt;
    }

    public function setUserPasswdSalt(string $userPasswdSalt): void
    {
        $this->userPasswdSalt = $userPasswdSalt;
    }


}
