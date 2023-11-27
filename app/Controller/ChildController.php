<?php

namespace App\Controller;

use App\Data\Child;
use App\Data\Person;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Core\Controller\AbstractController;
class ChildController extends AbstractController
{
    public function index(Request $request, Response $response, array $args = []): Response
    {
        $parent_id = $args['id'];
        $response->getBody()->write($this->render('createchild', compact('parent_id')));
        return $response;
    }

    public function post(Request $request, Response $response, array $args = []): Response{
        $info = $request->getParsedBody();
        $fname = htmlspecialchars($info['fname']);
        $lname = htmlspecialchars($info['lname']);
        if(!preg_match('/^[[:upper:]][[:lower:]]+([[:space:]][[:upper:]])?([[:space:]]?[[:upper:]][[:lower:]]+)*$/', $fname)
            || !preg_match('/^([[:upper:]]+[[:space:]]?)+$/', $lname ) ){
            $erreur = 'Erreur lors de la création veuillez réessayer';
        }
        $parentId = intval($info['parent_id']);
        $pin = htmlspecialchars($info['pin']);
        $date = $info['br-date'];
        $birth = new \DateTime($date);
        $gender = htmlspecialchars($info['gender']);
        $school_level = htmlspecialchars($info['school_level']);
        if($school_level=="NONE"){
            $school_level = null;
        }

        if(isset($erreur)){
            $response->getBody()->write($this->render('createchild', compact('parentId', 'erreur')));
            return $response;
        }else{
            $persRepo = $this->getEntityManager()->getRepository(Person::class);
            $childRepo = $this->getEntityManager()->getRepository(Child::class);
            $personId = $persRepo->addPerson($fname,$lname,$gender,$birth,$pin);
            $childRepo->addChild($personId,$parentId,$school_level);
            header("Location: /account");
            exit();
        }
    }

    public function remove(Request $request, Response $response, array $args = []):Response{
        $child_id = $args['id'];
        $childRep = $this->getEntityManager()->getRepository(Child::class);
        if(!empty($childRep->getChild($child_id))){
            $childRep->deleteChild($child_id);
        }
        header("Location: /account");
        exit();
    }

}