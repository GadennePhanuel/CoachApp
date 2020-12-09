<?php


namespace App\Controller;


use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Security;
use App\Entity\Coach;

class CoachController extends AbstractController
{
    private $teamRepository;
    private $manager;
    private $security;
    private $auth;

    public function __construct(Security $security, AuthorizationCheckerInterface $checker, TeamRepository $teamRepository, EntityManagerInterface $manager)
    {
        $this->teamRepository = $teamRepository;
        $this->manager = $manager;

        $this->security = $security;
        $this->auth = $checker;
    }

    /**
     * @Route("api/admins/coach/{coachId}/excludeOnTeams", methods={"PATCH"})
     * @param int $coachId
     * @return JsonResponse
     */
    public function excludeCoachOnAllTeams(int $coachId)
    {
        $code = 400;
        $message = "Wrong parameter, integer expected";
        if (is_numeric($coachId)) {
            $user = $this->security->getUser();
            $code = 401;
            $message = "Unauthorized";
            if ($this->auth->isGranted("ROLE_ADMIN")) {
                try {
                    $rep = $this->teamRepository->excludeCoachOnAllTeams($coachId, intVal($user->getClub()->getId()));
                        $code = 200;
                        $message = "coach are successfully exclude of these teams ";
                } catch (\Exception $e) {
                    $message = $e;
                }
            }
        }
        return $this->json(['message' => $message], $code);
    }
}