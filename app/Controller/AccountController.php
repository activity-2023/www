<?php
namespace App\Controller;

use Core\Controller\AbstractController;
use App\Data\Activity;
use App\Data\Child;
use App\Data\Event;
use App\Data\InternalStaff;
use App\Data\Organize;
use App\Data\Parents;
use App\Data\Participate;
use App\Data\Person;
use App\Data\Propose;
use App\Data\Staff;
use App\Data\Subscribe;
use App\Data\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AccountController extends AbstractController{
    public function index(Request $request, Response $response, array $args = []): Response{
        if(!isset($_SESSION['connexion'])){
            header("Location: /connexion");
            exit();
        }
        $idUser = $_SESSION['connexion'];
        $account_type = $_SESSION['account_type'];
        $entityManager = $this->getEntityManager();

        $userRepo = $entityManager->getRepository(User::class);
        $user = $userRepo->getUserById($idUser);

        $adminInfo = $this->personInfo($idUser);
        $login = $user->getUserLogin();

        if($account_type=="user"){
            $events = $this->getAssociatedEventsForUser($idUser);
            $activities = $this->getAssociatedActivitiesForUser($idUser);
            $account = $this->getParentInfo($idUser);
            $children = $this->getChildren();
        }
        elseif($account_type=="staff"){
            $activities = $this->getAssociatedActivitiesForStaff($idUser);
            $events = $this->getAssociatedEventsForStaff($idUser, $entityManager);
            $account = $this->getStaffInfo($idUser);
            $children =[];
        }
        $response->getBody()->write($this->render('account', compact('adminInfo', 'login',
            'account', 'activities', 'events', 'children')));
        return $response;
    }

    public function getChildren(){
        $childRep = $this->getEntityManager()->getRepository(Child::class);
        return $childRep->getChildrenByParentId($_SESSION['connexion']);
    }
    public function getChildInfo($child){
        $persRepo = $this->getEntityManager()->getRepository(Person::class);
        $person = $persRepo->getPerson($child['childId']);
        $person_info = $this->personInfo($child['childId']);
        $person_info['school_level'] = $child['childSchoolLevel'];
        return $person_info;
    }

    public function getStaffInfo(int $staff_id){

        $staffRep = $this->getEntityManager()->getRepository(Staff::class);
        $internalStaffRep = $this->getEntityManager()->getRepository(InternalStaff::class);

        $staff = $staffRep->getStaff($staff_id);
        $intStaff = $internalStaffRep->getInternalStaff($staff_id);

        $mail = $staff->getStaffEmail();
        $tel = $staff->getStaffPhone();
        $contract_type = $staff->getStaffContractType();

        $staff_function = $intStaff->getIntStaffFunction();
        $hr_number = $intStaff->getIntStaffHrNumber();
        $address = ['st-name'=>$intStaff->getAddressStreetName(),
            'st-num'=>$intStaff->getAddressStreetNumber(),
            'zip'=>$intStaff->getAddressZipCode(),
            'city'=>$intStaff->getAddressCity()
        ];

        return ['fonction'=>$staff_function, 'mail'=>$mail, 'tel'=>$tel,
            'address'=> $address, 'hr_number'=>$hr_number, 'contract_type'=>$contract_type];
    }

    public function getParentInfo($idParent): array
    {
        $parentRepo = $this->getEntityManager()->getRepository(Parents::class);
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


    public function getAssociatedActivitiesForUser($idUser): array|null
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('a')
            ->from(Activity::class, 'a')
            ->join(Subscribe::class, 's', 'WITH', 'a.activityId = s.activityId')
            ->where($queryBuilder->expr()->in('s.personId', ':personId'))
            ->setParameter('personId',$idUser)
            ->setMaxResults( 4 );
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }

    public function getAssociatedActivitiesForStaff($idUser): array|null{
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('a')
            ->from(Activity::class, 'a')
            ->join(Propose::class, 's', 'WITH', 'a.activityId = s.activityId')
            ->where('s.staffId = :personId')
            ->setParameter('personId',$idUser )
            ->setMaxResults( 4 );
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }

    public function getAssociatedEventsForUser(): array|null{
        $persons = $this->getPersonsAccount($_SESSION['connexion']);
        $parent = $persons['parent'];
        $children = $persons['children'];
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('e')
            ->from(Event::class, 'e')
            ->join(Participate::class, 'p', 'WITH', 'e.eventId = p.eventId')
            ->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->in('p.personId', ':parent'),
                    $queryBuilder->expr()->in('p.personId', ':children')
                    ),
                    $queryBuilder->expr()->gte('e.eventDate', ':date')
                )
            )
            ->orderBy('e.eventDate', 'DESC')
            ->setParameter('parent',$parent)
            ->setParameter('children', $children)
            ->setParameter('date', new \DateTime())
            ->setMaxResults( 4 );
        $query = $queryBuilder->getQuery();
        return $query->getResult();

    }

    public function getAssociatedEventsForStaff($idStaff): array|null{
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('e')
            ->from(Event::class, 'e')
            ->join(Organize::class, 'p', 'WITH', 'e.eventId = p.eventId')
            ->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq('p.staffId', ':personId'),
                    $queryBuilder->expr()->gte('e.eventDate', ':date')
                )
            )
            ->orderBy('e.eventDate', 'DESC')
            ->setParameter('personId',$idStaff)
            ->setParameter('date', new \DateTime())
            ->setMaxResults( 4 );
        $query = $queryBuilder->getQuery();
        return $query->getResult();

    }

    public function getEventInfo(Event $event):array
    {
        $activityRep =$this->getEntityManager()->getRepository(Activity::class);
        $activityName = $activityRep->getActivity($event->getActivityId())->getName();
        return [
            'id'=>$event->getEventId(),
            'date'=> $event->getEventDate()->format('Y/m/d'),
            'start_time'=>$event->getEventStartTime()->format('H:i'),
            'duration'=>$event->getEventDuration()->format('H:i'),
            'max_participant'=>$event->getEventMaxParticipant(),
            'activity_name'=>$activityName,
        ];
    }

}