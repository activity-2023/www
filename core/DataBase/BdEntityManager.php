<?php

namespace Core\DataBase;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\ORMSetup;
use Exception;

class BdEntityManager{
    private $dbName;
    private $user;
    private $password;
    private $host;
    private $driver;
    private $port;

    /**
     * @param string $dbName
     * @param string $user
     * @param string $password
     * @param string $host
     * @param string $driver
     * @param string $port
     */
    public function __construct(string $dbName ='projet', string $user = 'dania',
                                string $password = '000', string $host = 'localhost',
                                string $driver = 'pgsql', string $port = '9876'){
        $this->dbName = $dbName;
        $this->user = $user;
        $this->password = $password;
        $this->host = $host;
        $this->driver = $driver;
        $this->port = $port;
    }

    public function initConnection(): ?EntityManager{

        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: array(__DIR__."/../../data/"),
            isDevMode: true,
        );
        $connectionParams = [
            'dbname' => $this->dbName,
            'user' => $this->user,
            'password' => $this->password,
            'host' => $this->host,
            'driver' => $this->driver,
            'port'=> $this->port,
        ];
        try {
            $conn = DriverManager::getConnection($connectionParams, $config);
            $entityManager = new EntityManager($conn, $config);
        } catch (MissingMappingDriverImplementation|Exception $e) {
            echo "Echec de connexion à la base de données \n";
            echo $e->getMessage();
        }
        return $entityManager ?? Null;
    }

    }
