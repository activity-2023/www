<?php
namespace App\Controller;
use Core\Controller\AbstractController;
use App\Data\InternalStaff;
use App\Data\Parents;
use App\Data\Person;
use App\Data\Staff;
use App\Data\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RegisterController extends AbstractController {
    public function index(Request $request, Response $response, array $args = []): Response{
        $account_type = 'user';
        $response->getBody()->write($this->render('register', compact('account_type')));
       return $response;
    }
    public function post(Request $request, Response $response, array $args = []):Response{
        $info = $request->getParsedBody();
        $account_type = htmlspecialchars($info['account_type']);
        $fname = htmlspecialchars($info['fname']);
        $lname = htmlspecialchars($info['lname']);
        $date = $info['br-date'];
        $birth = new \DateTime($date);
        $gender = htmlspecialchars($info['gender']);
        $tel = htmlspecialchars($info['tel']);
        $mail = htmlspecialchars($info['email']);
        $login = htmlspecialchars($info['login']);
        $pin = $info['pin'];
        $pwd = $info['pswd'];
        $address = ['st-name'=>htmlspecialchars($info['ad-st-nam']),
            'st-num'=>$info['ad-st-num'],
            'zip'=>htmlspecialchars($info['ad-zip-code']),
            'city'=>htmlspecialchars($info['ad-city'])
        ];
        if(!preg_match('/^[[:upper:]][[:lower:]]+([[:space:]][[:upper:]])?([[:space:]]?[[:upper:]][[:lower:]]+)*$/', $fname)
            || !preg_match('/^([[:upper:]]+[[:space:]]?)+$/', $lname )
            || !preg_match('/^0[1-9][[:digit:]]{8}$/', $tel)
            || !preg_match('/^[\w!#$%&\'/*+=?`{|}~^-]+(?:\.[\w!#$%&\'/*+=?`{|}~^-]+)*@(?:[a-z0-9-]+\.)+[a-z]{2,6}$/', $mail)
            || !preg_match('/^[[:lower:]][a-z0-9]+$/', $login)){
            $indispo = 'Erreur lors de la création veuillez réessayer';

        }

        $entityManager = $this->getEntityManager();
        $userRepo = $entityManager->getRepository(User::class);
        $persRepo = $entityManager->getRepository(Person::class);
        $parentRepo = $entityManager->getRepository(Parents::class);
        $staffRep = $entityManager->getRepository(Staff::class);
        $interStaffRep = $entityManager->getRepository(InternalStaff::class);

        if(!empty($userRepo->getUserByLogin($login))) {
            $indispo = 'Votre login est indisponible';
        }
        if($account_type=="user"){
            if(isset($info['job'])){
                $job = htmlspecialchars($info['job']);
            }
            else {
                $job = '';
            }
        }
        elseif ($account_type=="staff"){
            $contract_type = htmlspecialchars($info['contract_type']);
            $hr_number = $info['hr_number'];
            $function = htmlspecialchars($info['staff_function']);

            if(!empty($staffRep->getStaffByEmail($mail))){
                $indispo = 'Votre mail doit être unique';
            }elseif (!empty($staffRep->getStaffByTel($tel))) {
                $indispo = 'Votre Numéro de téléphone professionnel est unique';
           }
            elseif(!empty($interStaffRep->getInternalStaffByHrNumber($hr_number))){
                $indispo = 'Votre Numéro RH est unique';
            }
        }
        if(!isset($indispo)) {
            $id = $persRepo->addPerson($fname, $lname, $gender, $birth, $pin);
            $userRepo->addUser($id, $login, $pwd);
            if($account_type=="user") {
                $parentRepo->addParent($id, $mail, $tel, $address['st-num'], $address['st-name'],
                    $address['zip'], $address['city'], $job ?? null);
            }elseif($account_type=="staff") {
                $staffRep->addStaff($id, $mail, $tel, $contract_type);
                $interStaffRep->addInternalStaff($id, $hr_number, $function, $address['st-num'], $address['st-name'],
                    $address['zip'], $address['city']);
            }
            if(!isset($_SESSION['connexion'])){
                $_SESSION['connexion'] = $id;
                $_SESSION['account_type'] = $account_type;
            }
            header("Location: /account");
            exit();
        }
        $response->getBody()->write($this->render('register', compact('indispo',
            'lname','fname', 'date', 'gender', 'login', 'tel','pin', 'mail', 'address', 'account_type') ));

        return $response;
    }

    public function staff(Request $request, Response $response, array $args = []):Response{
        $account_type = 'staff';
        $response->getBody()->write($this->render('register', compact('account_type')));
        return $response;
    }

}
