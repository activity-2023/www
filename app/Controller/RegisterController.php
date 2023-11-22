<?php
namespace App\Controller;
use Core\Controller\AbstractController;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RegisterController extends AbstractController {
    public function index(Request $request, Response $response): Response{
        $response->getBody()->write($this->render('register'));
       return $response;
    }

    public function post(Request $request, Response $response, $args = []):Response{
        $info = $request->getParsedBody();

        return $response;
    }



}
