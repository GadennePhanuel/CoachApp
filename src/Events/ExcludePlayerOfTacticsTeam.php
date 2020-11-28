<?php


namespace App\Events;

use App\Entity\Player;
use App\Repository\TacticRepository;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ExcludePlayerOfTacticsTeam implements EventSubscriberInterface
{
     private $tacticRepo;

    public function __construct(TacticRepository $tacticRepo)
    {
          $this->tacticRepo = $tacticRepo;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['excludePlayerOfTactics', EventPriorities::POST_WRITE]
        ];
    }

    /**
     * @param ViewEvent $event
     * @Route("/api/admins/user/{userId}/excludeOnTeams", methods={"PATCH"})
     */
    public function excludePlayerOfTactics(ViewEvent $event)
    {
             $result = $event->getControllerResult();
             $request = $event->getRequest();
             $method = $request->getMethod();

                if ($result instanceof Player && $method === "PUT" && $request->query->get('team') === null){
                    $player = $result;
                    $this->tacticRepo->excludePlayerOfTactics($player->getId());

                }
    }
}