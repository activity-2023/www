<?php
declare(strict_types=1);

use App\Controller\AccountController;
use App\Controller\ActivitiesController;
use App\Controller\ActivityController;
use App\Controller\CancelController;
use App\Controller\ChildController;
use App\Controller\ConnexionController;
use App\Controller\EventsController;
use App\Controller\RegisterController;
use App\Controller\SubscribeController;
use Slim\Factory\AppFactory;
use App\Controller\HomeController;
use App\Controller\RoomChoiceController;
use App\Controller\StaffFonctionController;

require __DIR__.'/../vendor/autoload.php';

session_start();

$app = AppFactory::create();

$app->addErrorMiddleware(true, false, false);
$app->addBodyParsingMiddleware();


$app->get('/', HomeController::class.':index');
$app->get('/account', AccountController::class.':index');
$app->post('/account', AccountController::class.':index');

$app->get('/register', RegisterController::class.':index');
$app->post('/register', RegisterController::class.':post');
$app->get('/subscribe/id={id}', SubscribeController::class.':index');

$app->get('/connexion', ConnexionController::class.':index');
$app->post('/connexion', ConnexionController::class.':post');
$app->get('/deconnexion', ConnexionController::class.':deconnexion');

$app->get('/activities', ActivitiesController::class.':index');
$app->get('/activity/id={id}', ActivityController::class.':index');

$app->post('/activitycreation',ActivitiesController::class.':activityAdd');
$app->get('/activitycreation',ActivitiesController::class.':createActivity');

$app->get('/event/id={id}/name={name}',EventsController::class.':index');
$app->post('/event',EventsController::class.':post');
$app->get('/inscription/id={id_event}', EventsController::class.':personChoice');
$app->get('/inscription/id={id_event}/{person_id}', EventsController::class.':inscription');

$app->get('/reserve/id_room={room_id}/event_date={eventDate}/event_start={eventStartTime}/event_duration={eventduration}/event_max_participant={eventMaxParticipant}/id_activity={activityId}',RoomChoiceController::class.':index');

$app->get('/user_account_creation', StaffFonctionController::class.':index');
$app->get('/staff_account_creation', StaffFonctionController::class.':staff');

$app->get('/cancel_event/id={id}', CancelController::class.':index');
$app->get('/cancel_activity/id={id}', CancelController::class.':cancel_activity');
$app->get('/unsubscribe_event/id={id_event}', EventsController::class.':personChoice');
$app->get('/unsubscribe_event/id={id}/{personId}', CancelController::class.':unsubscribe_event');
$app->get('/unsubscribe_activity/id={id}', CancelController::class.':unsubscribe_activity');
$app->get('/join_activity/id={id}',StaffFonctionController::class.':joinActivity');
$app->get('/join_event/id={id}',StaffFonctionController::class.':joinEvent');


$app->get('/addchild/id={id}', ChildController::class.':index');
$app->get('/removechild/id={id}', ChildController::class.':remove');
$app->post('/addchild', ChildController::class.':post');

$app->run();