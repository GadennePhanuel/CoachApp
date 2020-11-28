<?php


namespace App\Controller;


use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CoachController extends AbstractController
{
    private $teamRepository;
    private $manager;

    public function __construct(TeamRepository $teamRepository, EntityManagerInterface $manager)
    {
        $this->teamRepository = $teamRepository;
        $this->manager = $manager;
    }

    /**
     * @Route("api/admins/coach/{coachId}/excludeOnTeams", methods={"PATCH"})
     * @param $coachId
     * @return JsonResponse
     */
    public function excludeCoachOnAllTeams($coachId){
        try{
            $this->teamRepository->excludeCoachOnAllTeams($coachId);
            $message = 'user exclude of teams success';
        }catch(\Exception $e){
            $message = $e;
        }
        return $this->json(['message' => $message,], 200);
    }
}