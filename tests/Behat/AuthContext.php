<?php

namespace App\Tests\Behat;

use App\Entity\Club;
use App\Entity\User;
use App\Repository\UserRepository;
use Behatch\Context\BaseContext;
use Behatch\HttpCall\Request;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class AuthContext extends BaseContext
{

    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var JWTTokenManagerInterface
     */
    private $tokenManager;
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request, EntityManagerInterface $manager, UserRepository $userRepository, JWTTokenManagerInterface $tokenManager)
    {
        $this->manager = $manager;
        $this->userRepository = $userRepository;
        $this->tokenManager = $tokenManager;
        $this->request = $request;
    }


    /**
     * @Given /^I authenticate using the email address "([^"]*)" having the role "([^"]*)"$/
     * @param $email
     * @param $role
     */
    public function iAuthenticateUsingTheEmailAddressHavingTheRole($email, $role)
    {
        $user = $this->userRepository->findOneBy(["email" => $email]);
        if(!$user){
            $user = new User();
            $club = new Club();
            $club->setLabel("tmpClub");
            $this->manager->persist($club);
            $user->setEmail($email)->setBirthday(new \DateTime('01-01-1990'))->setFirstName("tmpUser")->setLastName("tmpUser")->setPassword("test59")->setPhone("0303030303")
                ->setClub($club)->setRoles([$role]);
            $this->manager->persist($user);
            $this->manager->flush();
        }

        $token = $this->tokenManager->create($user);

        $this->request->setHttpHeader("Authorization", "Bearer $token");
    }
}