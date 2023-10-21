<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Core\Controller\AbstractController;


class HomeController extends AbstractController{
    public function index(Request $request, Response $response ): Response{
        $response->getBody()->write($this->render('home'));
        return $response;
    }
}
