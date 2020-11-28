<?php


namespace App\Controller;


use App\Repository\ClubRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ClubRepository
     */
    private $clubRepository;
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     * @param ClubRepository $clubRepository
     * @param EntityManagerInterface $manager
     */
    public function __construct(UserRepository $userRepository, ClubRepository $clubRepository, EntityManagerInterface $manager)
    {

        $this->userRepository = $userRepository;
        $this->clubRepository = $clubRepository;
        $this->manager = $manager;
    }

    /**
     * @Route("api/user/{userId}/club/{clubId}", methods={"PUT"})
     * @param $userId
     * @param $clubId
     */
    public function setClubForUserAdmin($userId, $clubId){
        $user = $this->userRepository->find($userId);
        $club = $this->clubRepository->find($clubId);

        $user->setClub($club);
        $this->manager->persist($user);
        $this->manager->flush();

        return $this->json(['message' => 'modification de l\'utilisateur confirmé'], 200);
    }

    /**
     * @Route("api/admins/user/{userId}/{userType}/{allowed}", methods={"PATCH"})
     * @param Int $userId
     * @param String $userType
     * @param String $allowed
     */
    public function switchAllowed(int $userId, string $userType, string $allowed)
    {
        $rep = null;
        if ($allowed === "debloquer") {
            switch ($userType) {
                case "player":
                    $rep = $this->userRepository->switchPlayerToAllowed($userId);
                    break;
                case "coach":
                    $rep = $this->userRepository->switchCoachToAllowed($userId);
                    break;
            }
        } else if ($allowed === "bloquer") {
            switch ($userType) {
                case "player":
                    $rep = $this->userRepository->switchPlayerToNotAllowed($userId);
                    break;
                case "coach":
                    $rep = $this->userRepository->switchCoachToNotAllowed($userId);
                    break;
            }
        }

        return $this->json(['message' => $rep,], 200);
    }
}