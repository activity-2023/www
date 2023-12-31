<?php

namespace App\Repository;

use App\Data\Activity;
use Doctrine\ORM\EntityRepository;

/**
 * @method Activity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activity[] findAll()
 * @method Activity[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityRepository extends EntityRepository
{
    public function addActivity(string $name, string $description, int $minAge, float $price): int{
        $activity = new Activity();
        $activity->setName($name);
        $activity->setDescription($description);
        $activity->setMinAge($minAge);
        $activity->setPrice($price);
        $this->getEntityManager()->persist($activity);
        $this->getEntityManager()->flush();
        return $activity->getActivityId();
    }
    public function getActivity(int $activityId) : Activity|null{
        return $this->find($activityId);
    }
    public function getAllActivities() : array|null{
        return $this->findBy([], ['activityId' => 'DESC']);
    }
}
