<?php

namespace Core\DataBase;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\ORMSetup;
use Exception;

class Bootstrap{
    private string $dbName = 'activity';

    private string $user;

    private string $password;

    private string $host;

    private string $driver = 'pgsql';

    private string $port;

    public function __construct() {
        $this->user = getenv('DB_USER');
        $this->password = getenv('DB_PASSWORD');
        $this->host = getenv('DB_HOST');
        $this->port = getenv('DB_PORT');
    }

    public function initConnection(): ?EntityManager{
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: array(__DIR__ . "/../../Data/"),
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


