<?php
namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordEncoderSubscriber implements EventSubscriberInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public static function getSubscribedEvents()
    {
        return [
                KernelEvents::VIEW => ['encodePassword',  EventPriorities::PRE_WRITE]
                //donc là on parle au coeur même de Symfony = le Kernel; on lui dit -> Voilà, notre Classe elle s'intéresse à l'événement qui s'appelle VIEW,
                //                   et elle veut se placer AVANT l'écriture dans la base de donnée et tu appelleras la fonction qui s'appelle encodePassword
        ];
    }

    //donc maintenant let's go, on crée notre fameuse fonction encodePassword. qui recevra en propriété un $event qui est => l'événement passé par le Kernel (en gros le kernel appelle la fonction et lui dit "tiens, voilà l'événement en cours)
    public function encodePassword (ViewEvent $event){
        // $event a un type bien particulier, içi c'est un objet de type ViewEvent ! (on a la liste de ces trucs là dans la doc de apiPlatform)
        // donc, $event représente l'événement qui s'est produit à l'instant
        $result = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        //Ici il faut bien comprendre que cette classe, cette fonction sera appelé à CHAQUES REQUÊTES, il n'y a aucune différenciation
        // donc on utilise un if, içi on cherche à encoder les passwords, donc: la fonction doit s'exécuter uniquement si la requête est faite sur un User et uniquement si c'est en method POST (pour en créer un ! )

        if ($result instanceof User && ($method === "POST" || $method === "PUT")){
            $user = $result;
            $hash = $this->encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
        }
    }

}