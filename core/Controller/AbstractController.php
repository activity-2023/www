<?php
declare(strict_types=1);

namespace Core\Controller;
use Core\DataBase\Bootstrap;
use Data\Activity;
use Data\Event;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

abstract  class AbstractController {
    private const TEMPLATES_DIR = __DIR__.'/../../templates/';
    private const LAYOUT_PATH = self::TEMPLATES_DIR.'layout/layout.php';

    private EntityManager $entityManager;

    public function __construct(){
        $conDataBase = new Bootstrap();
        $this->entityManager = $conDataBase->initConnection();
    }

    public function getEntityManager():EntityManager{
        return $this->entityManager;
    }

    public function render(string $template, array $data = [] ):string{
        extract($data);
        $templatePath = self::TEMPLATES_DIR.$template.'.php';
        ob_start();
        include ($templatePath);
        $content = ob_get_clean();
        ob_start();
        include (self::LAYOUT_PATH);
        return ob_get_clean();
    }

    public abstract function index(Request $request, Response $response, array $args = []): Response;

    public function getActivityInfo(Activity $activity): array
    {
        return [
            'id'=>$activity->getActivityId(),
            'name'=> $activity->getName(),
            'description'=>$activity->getDescription(),
            'minAge'=>$activity->getMinAge(),
            'price'=>$activity->getPrice()
        ];
    }

    public function getEventInfo(Event $event):array
    {
        $activityRep =$this->entityManager->getRepository(Activity::class);
        $activityName = $activityRep->getActivity($event->getActivityId())->getName();
        return [
            'id'=>$event->getEventId(),
            'date'=> date_format($event->getEventDate(), "Y/m/d"),
            'start_time'=>date_format($event->getEventStartTime(), "h:m"),
            'duration'=>date_format($event->getEventDuration(), "h:m"),
            'max_participant'=>$event->getEventMaxParticipant(),
            'activity_name'=>$activityName
        ];
    }


}
