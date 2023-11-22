<?php
declare(strict_types=1);

use App\Controller\EventsController;
use App\Controller\RegisterController;
use Slim\Factory\AppFactory;
use App\Controller\HomeController;
use App\Controller\AccountController;
use App\Controller\ConnexionController;

require __DIR__.'/../vendor/autoload.php';

$app = AppFactory::create();

$app->addErrorMiddleware(true, false, false);
$app->addBodyParsingMiddleware();

$app->get('/', HomeController::class.':index');
$app->get('/account', AccountController::class.':index');
$app->post('/account', AccountController::class.':index');
$app->get('/register', RegisterController::class.':index');
$app->post('/register', RegisterController::class.':post');
$app->get('/events', EventsController::class.':index');
$app->get('/connexion', ConnexionController::class.':index');
$app->post('/connexion', ConnexionController::class.':post');

$app->run();