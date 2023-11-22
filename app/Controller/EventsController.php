<?php

namespace  App\Controller;

use Core\Controller\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class EventsController extends AbstractController{
    public function index(Request $request, Response $response): Response{
        $response->getBody()->write($this->render('events'));
        return $response;
    }
}
