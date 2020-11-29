<?php

namespace App\Events;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JwtCreatedUser
{
    public function updateJwtData(JWTCreatedEvent $event)
    {
        //récupération du user
        $user = $event->getUser();
        //enrichir les data (payload) pour qu'elles contiennent ces données
        $data = $event->getData();
        $data['firstName'] = $user->getFirstName();
        $data['lastName'] = $user->getLastName();
        $data['id'] = $user->getId();
        if($data['roles'][0] === 'ROLE_PLAYER' || $data['roles'][1] === 'ROLE_PLAYER') {
            $player = $user->getPlayers()[0];

            if ($player != null){
                $data['player'] = $player->getId();;
                $teams = $player->getTeam();
                if($teams != null){
                    $data['team'] = $teams->getId();
                }
                else {
                    $data['team'] = null;
                }
            }else{
                $date['player'] = null;
            }
        }
        else if($data['roles'][0] === 'ROLE_COACH' || $data['roles'][1] === 'ROLE_COACH') {
            $coach = $user->getCoaches()[0];
            if ($coach != null){
                $data['coach'] = $coach->getId();
            }else{
                $data['coach'] = null;
            }


        }
        if (!empty($user->getClub())){
            $data['club'] = $user->getClub()->getId();
        }else{
            $data['club'] = null;
        }

        $event->setData($data);
    }
}
