<?php
namespace App\Controller;

use Core\Controller\AbstractController;
use Data\Activity;
use Data\Event;
use Data\Parents;
use Data\Participate;
use Data\Person;
use Data\Subscribe;
use Data\User;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AccountController extends AbstractController{
    public function index(Request $request, Response $response, array $args = []): Response{
        if(!isset($_SESSION['connexion'])){
            header("Location: /connexion");
            exit();
        }
        $idUser = $_SESSION['connexion'];

        $entityManager = $this->getEntityManager();

        $userRepo = $entityManager->getRepository(User::class);
        $user = $userRepo->getUserById($idUser);

        $persRepo = $entityManager->getRepository(Person::class);
        $person = $persRepo->getPerson($idUser);

        $nom = $person->getPersonLname();
        $prenom = $person->getPersonFname();
        $birth = $person->getPersonBirthDate();
        $gender = $person->getPersonGender();
        $login = $user->getUserLogin();

        // if parent
        $parent_info = $this->getParentInfo($idUser, $entityManager);

        $activities = $this->getAssociatedActivities($idUser, $entityManager);
        $events = $this->getAssociatedEvents($idUser, $entityManager);

        $response->getBody()->write($this->render('account', compact('nom',
            'prenom', 'birth', 'gender', 'login', 'parent_info', 'activities', 'events' )));
        return $response;
    }

    public function getChildren(){

    }
    public function getStaffInfo(){

    }

    public function getParentInfo($idParent, EntityManager $entityManager): array
    {
        $parentRepo = $entityManager->getRepository(Parents::class);
        $parent = $parentRepo->getParent($idParent);

        $mail =  $parent->getParentEmail();
        $tel = $parent->getParentPhone();
        $address = ['st-name'=>$parent->getAddressStreetName(),
            'st-num'=>$parent->getAddressStreetNumber(),
            'zip'=>$parent->getAddressZipCode(),
            'city'=>$parent->getAddressCity()
        ];
        $job = $parent->getParentJob();

        return ['job'=>$job, 'mail'=>$mail, 'tel'=>$tel,'address'=> $address];
    }
    public function getAssociatedActivities($idUser, EntityManager $entityManager): array|null{
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('A')
            ->from(Activity::class, 'A')
            ->join(Subscribe::class, 's', 'WITH', 'A.activityId = s.activityId')
            ->where('s.personId = :personId')
            ->orderBy('s.suscriptionDate', 'DESC')
            ->setParameter('personId',$idUser )
            ->setMaxResults( 4 );
        $query = $queryBuilder->getQuery();
        return $query->getResult();

    }

    public function getAssociatedEvents($idUser, EntityManager $entityManager): array|null{
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('e')
            ->from(Event::class, 'e')
            ->join(Participate::class, 'p', 'WITH', 'e.eventId = p.eventId')
            ->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq('p.personId', ':personId'),
                    $queryBuilder->expr()->gte('e.eventDate', ':date')
                )
            )
            ->orderBy('e.eventDate', 'DESC')
            ->setParameter('personId',$idUser)
            ->setParameter('date', new \DateTime())
            ->setMaxResults( 4 );
        $query = $queryBuilder->getQuery();
        return $query->getResult();

    }


}