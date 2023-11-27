<?php

namespace App\Repository;

use App\Data\Building;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;

/**
 * @method Building|null find($id, $lockMode = null, $lockVersion = null)
 * @method Building|null findOneBy(array $criteria, array $orderBy = null)
 * @method Building[] findAll()
 * @method Building[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuildingRepository extends EntityRepository
{
    public function addBuilding(string $name, int $addressStreetNumber, string $addressStreetName,
                                string $addressZipCode, string $addressCity, int $nbFloors, bool $hasElevator){
        $building = new Building();
        $building->setBuildingName($name);
        $building->setAddressCity($addressCity);
        $building->setAddressZipCode($addressZipCode);
        $building->setAddressStreetName($addressStreetName);
        $building->setAddressStreetNumber($addressStreetNumber);
        $building->setBuildingNbFloors($nbFloors);
        $building->setBuildingHasElevator($hasElevator);

        $this->getEntityManager()->persist($building);
        $this->getEntityManager()->flush();

    }

    public function getBuildingWithId(string $id): Building|null{
        return $this->find($id);
    }


}
