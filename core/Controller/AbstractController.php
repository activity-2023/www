<?php
declare(strict_types=1);

namespace Core\Controller;
use Core\DataBase\Bootstrap;
use App\Data\Activity;
use App\Data\Child;
use App\Data\Event;
use App\Data\Participate;
use App\Data\Person;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

abstract  class AbstractController {
    private const TEMPLATES_DIR = __DIR__.'/../../templates/';
    private const LAYOUT_PATH = self::TEMPLATES_DIR.'layout/layout.php';

    private EntityManager $entityManager;

    public function __construct(){
        $conDataBase = new Bootstrap();
        $this->entityManager = $conDataBase->initConnection();
    }

    public function getEntityManager():EntityManager{
        return $this->entityManager;
    }

    public function render(string $template, array $data = [] ):string{
        extract($data);
        $templatePath = self::TEMPLATES_DIR.$template.'.php';
        ob_start();
        include ($templatePath);
        $content = ob_get_clean();
        ob_start();
        include (self::LAYOUT_PATH);
        return ob_get_clean();
    }

    public abstract function index(Request $request, Response $response, array $args = []): Response;


    public function getPersonsAccount(int $id){
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('person.personId')
            ->from(Person::class, 'person')
            ->where('person.personId = :parentId')
            ->setParameter('parentId', $_SESSION['connexion']);
        $parent = $queryBuilder->getQuery()->getArrayResult()[0];

        $queryb = $this->getEntityManager()->createQueryBuilder();
        $queryb->select('person.personId')
            ->from(Person::class, 'person')
            ->join(Child::class, 'child', 'WITH', 'child.childId = person.personId')
            ->where('child.parentId = :parentId')
            ->orWhere('person.personId = :parentId')
            ->setParameter('parentId', $id);
        $child = $queryb->getQuery()->getArrayResult();

        return ['children'=>$child, 'parent'=>$parent];
    }

    public function allreadyParticipate($id_event, $person_id){
        $queryB = $this->getEntityManager()->createQueryBuilder();
        $queryB->select('participate')
            ->from(Participate::class, 'participate')
            ->where('participate.eventId = :eventId')
            ->andWhere('participate.personId = :personId')
            ->setParameter('eventId', $id_event)
            ->setParameter('personId', $person_id);
        return $queryB->getQuery()->getResult();
    }
    public function personInfo(int $personId){
        $personRep = $this->entityManager->getRepository(Person::class);
        $person = $personRep->getPerson($personId);
        return [
            'lname'=>$person->getPersonLname(),
            'fname'=>$person->getPersonFname(),
            'gender'=>$person->getPersonGender(),
            'id'=>$person->getPersonId(),
            'birth'=>$person->getPersonBirthDate()->format('Y/m/d'),
        ];
    }
    public function getActivityInfo(Activity $activity): array
    {
        return [
            'id'=>$activity->getActivityId(),
            'name'=> $activity->getName(),
            'description'=>$activity->getDescription(),
            'minAge'=>$activity->getMinAge(),
            'price'=>$activity->getPrice()
        ];
    }

}
