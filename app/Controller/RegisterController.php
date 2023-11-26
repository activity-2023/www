<?php
namespace App\Controller;
use Core\Controller\AbstractController;
use Data\Parents;
use Data\Person;
use Data\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RegisterController extends AbstractController {
    public function index(Request $request, Response $response, array $args = []): Response{
        $response->getBody()->write($this->render('register'));
       return $response;
    }

    public function post(Request $request, Response $response, array $args = []):Response{
        $info = $request->getParsedBody();
        $fname = $info['fname'];
        $lname = $info['lname'];
        $date = $info['br-date'];
        $birth = new \DateTime($date);
        $gender = $info['gender'];
        $tel = $info['tel'];
        $mail = $info['email'];
        $login = $info['login'];
        $pin = $info['pin'];
        $pwd = $info['pswd'];
        $address = ['st-name'=>$info['ad-st-nam'],
            'st-num'=>$info['ad-st-num'],
            'zip'=>$info['ad-zip-code'],
            'city'=>$info['ad-city']
        ];

        $entityManager = $this->getEntityManager();
        $userRepo = $entityManager->getRepository(User::class);
        if(is_null($userRepo->getUserByLogin($login))){

            $persRepo = $entityManager->getRepository(Person::class);
            $id = $persRepo->addPerson($fname, $lname, $gender, $birth, $pin);

            $userRepo->addUser($id, $login, $pwd);
            // si c'est un parent
            $parentRepo = $entityManager->getRepository(Parents::class);
            $parentRepo->addParent($id, $mail, $tel, $address['st-num'], $address['st-name'],
                $address['zip'], $address['city']);
            // si c'est un staff

            //
            $_SESSION['connexion'] = $id;
            $_SESSION['account-type'] = 'user';

            header("Location: /account");
            exit();

        }
        else{
            $dispo_log = 'login indisponible';
            $response->getBody()->write($this->render('register', compact('dispo_log',
                'lname','fname', 'date', 'gender', 'login', 'tel','pin', 'mail', 'address') ));
        }
        return $response;
    }



}
