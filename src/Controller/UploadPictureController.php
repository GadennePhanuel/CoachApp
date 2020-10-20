<?php


namespace App\Controller;


use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class UploadPictureController extends AbstractController
{

    /**
     * @var Security
     */
    private $security;
    /**
     * @var PlayerRepository
     */
    private $playerRepository;
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(Security $security, PlayerRepository $playerRepository, EntityManagerInterface $manager)
    {

        $this->security = $security;
        $this->playerRepository = $playerRepository;
        $this->manager = $manager;
    }

    /**
     * @param Request $request
     * @Route("/api/upload/test", methods={"POST"})
     * @return JsonResponse
     */
    public function temporaryUploadAction(Request $request)
    {
         //1. on commence par récupérer l'objet envoyé (normalement une image)
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('image');
        //2. On vérifie si on a bien reçu quelque chose et si l'extension du fichier et bien du .jpeg. Si c'est pas le cas, on renvoie un message d'erreur
        if($uploadedFile !== null){
            if(pathinfo($uploadedFile->guessClientExtension())["filename"] === "jpeg"){
                //3. création du path pour le dossier de destination du stockage de l'image
                $destination =  $this->getParameter('kernel.project_dir').'/public/uploads';

                //4. transformation du nom de l'image en valeur UNIQUE pour pas de conflit plus tard entre les utilisateurs
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $filenameWithoutExtension = Urlizer::urlize($originalFilename).'-'.uniqid();
                $newFilename = $filenameWithoutExtension.'.'.$uploadedFile->guessClientExtension();

                //5. on récupère l'utilisateur connecté, on vérifie que c'est bien un ROLE_PLAYER
                $user = $this->security->getUser();
                $role = $user->getRoles();

                if($role[0] === 'ROLE_PLAYER'){
                    //6. on récupère le player correspondant
                    $player = $this->playerRepository->findBy(['user' => $user]);
                    $player = $player[0];

                    //7. on vérifie si le player à déjà un photo de profil ou non.
                    if ( $player->getPicture()){
                        $originalPicture = $player->getPicture();
                        //Si oui on la supprime
                        unlink('uploads/' . $originalPicture . ".jpeg");
                    }
                    //8. on lui attribue la nouvelle image
                    $player->setPicture($filenameWithoutExtension);
                    //9. déplacement de l'image dans le dossier de destination
                    $uploadedFile->move(
                        $destination,
                        $newFilename
                    );

                    $this->manager->persist($player);
                    $this->manager->flush();

                    //renvoie message success
                    return $this->json(["success" => true, "response" => "Nouvelle photo de profil bien enregistré !", "location" => $destination ], 200);
                }else{
                    return $this->json(["success" => false, "violations" => "Vous n'avez pas les droits" ], 400);
                }
            }else{
                return $this->json(["success" => false, "violations" => "Votre image n'est pas au format .jpeg" ], 400);
            }
        }else{
            return $this->json(["success" => false, "violations" => "Vous n'avez rien envoyé" ], 400);
        }
    }

    /**
     * @param string $file
     * @Route("/api/image/{file}")
     * @return BinaryFileResponse
     */
    public function getProfilePicture(string $file)
    {
        $destination =  $this->getParameter('kernel.project_dir').'/public/uploads';
        $path = $destination .'/'. $file .".jpeg";
        if (file_exists($path)){
            return new BinaryFileResponse($path);
        }else{
            return $this->json(["success" => false, "violations" => "l'image demandée n'existe pas"], 400);
        }
    }
}