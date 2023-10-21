<?php
declare(strict_types=1);
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;

use App\Controller\HomeController;
use App\Controller\AccountController;
use App\Controller\RegisterController;

require __DIR__.'/../vendor/autoload.php';

$app = AppFactory::create();

$app->addErrorMiddleware(true, false, false);

$app->get('/', HomeController::class.':index')->setName('home');
$app->get('/account', AccountController::class.':index')->setName('account');
$app->get('/register', RegisterController::class.':index')->setName('register');

$app->run();