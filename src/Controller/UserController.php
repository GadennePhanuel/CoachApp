<?php


namespace App\Controller;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ClubRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class UserController
 * @package App\Controller
 */
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

    private $security;
    private $auth;

    /**
     * UserController constructor.
     * @param Security $security
     * @param AuthorizationCheckerInterface $checker
     * @param UserRepository $userRepository
     * @param ClubRepository $clubRepository
     * @param EntityManagerInterface $manager
     */
    public function __construct(Security $security, AuthorizationCheckerInterface $checker, UserRepository $userRepository, ClubRepository $clubRepository, EntityManagerInterface $manager)
    {

        $this->userRepository = $userRepository;
        $this->clubRepository = $clubRepository;
        $this->manager = $manager;

        $this->security = $security;
        $this->auth = $checker;

    }

    /**
     * @param $userId
     * @param $clubId
     * @return JsonResponse
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
     * Add or remove the role Not_Allowed to a user
     * @Route("api/admins/user/{userId}/{userType}/{allowed}", methods={"PATCH"})
     * @param Int $userId
     * @param String $userType
     * @param String $allowed
     * @return JsonResponse
     */
    public function switchAllowed(int $userId, string $userType, string $allowed)
    {
        if($this->auth->isGranted("ROLE_ADMIN")) {
            $currentClub = intval($this->security->getUser()->getClub()->getId());
            $rep = false;
            $code = 400;
            $message = "Failed: wrong parameter: allowed";
            if ($allowed === "unblock") {
                $message = "Failed: wrong parameter: userType";
                switch ($userType) {
                    case "player":
                        $rep = $this->userRepository->switchPlayerToAllowed($userId, $currentClub);
                        break;
                    case "coach":
                        $rep = $this->userRepository->switchCoachToAllowed($userId, $currentClub);
                        break;
                }
            } else if ($allowed === "block") {
                $message = "Failed: wrong parameter: userType";
                switch ($userType) {
                    case "player":
                        $rep = $this->userRepository->switchPlayerToNotAllowed($userId, $currentClub);
                        break;
                    case "coach":
                        $rep = $this->userRepository->switchCoachToNotAllowed($userId, $currentClub);
                        break;
                }
            }

            if ($rep == true) {
                $code = 200;
                $message = "success: user access is updated";
            } else {
                $code = 404;
                $message = "failed: Resource not found";
            }
        }
    else {
        $code = 401;
        $message = "Unauthorized";
    }
        return $this->json($message, $code);
    }

    /*
 * {
  "tags": [
    "pet"
  ],
  "summary": "Updates a pet in the store with form data",
  "operationId": "updatePetWithForm",
  "parameters": [
    {
      "name": "petId",
      "in": "path",
      "description": "ID of pet that needs to be updated",
      "required": true,
      "schema": {
        "type": "string"
      }
    }
  ],
  "requestBody": {
    "content": {
      "application/x-www-form-urlencoded": {
        "schema": {
          "type": "object",
          "properties": {
            "name": {
              "description": "Updated name of the pet",
              "type": "string"
            },
            "status": {
              "description": "Updated status of the pet",
              "type": "string"
            }
          },
          "required": ["status"]
        }
      }
    }
  },
  "responses": {
    "200": {
      "description": "Pet updated.",
      "content": {
        "application/json": {},
        "application/xml": {}
      }
    },
    "405": {
      "description": "Method Not Allowed",
      "content": {
        "application/json": {},
        "application/xml": {}
      }
    }
  },
  "security": [
    {
      "petstore_auth": [
        "write:pets",
        "read:pets"
      ]
    }
  ]
}
 * */
}