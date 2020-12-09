<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 * @ApiResource(
 *     normalizationContext={
            "groups"={"admins_read"}
 *     },
 *     itemOperations={"GET",
 *          "PUT"={"security"="is_granted('ROLE_ADMIN')"},
 *          "DELETE"={"security"="is_granted('ROLE_ADMIN')"}
 *     },
 *     collectionOperations={"GET", "POST",
 *          "sendEmailCoach"={
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "method"="post",
 *              "path"="/emailCoach",
 *              "controller"="App\Controller\MailerRegisterCoachController",
 *              "openapi_context"={
 *                  "summary"="invite a coach to join a club",
 *                  "description"="send an email with a unique token for registration",
 *                  "parameters"={
 *                      {
 *                          "in"="query",
 *                          "name"="url",
 *                          "schema"={"type"="string"},
 *                          "required"="true"
 *                      },
 *                      {
 *                          "in"="query",
 *                          "name"="club",
 *                          "schema"={"type"="integer"},
 *                          "required"="true",
 *                          "description"="club id"
 *                      },
 *                      {
 *                          "in"="query",
 *                          "name"="email",
 *                          "schema"={"type"="string"},
 *                          "required"="true",
 *                          "description"="email coach"
 *                      }
 *                  },
 *                  "requestBody"={
 *                      "content"={
 *                          "application/json"={
 *                              "schema"={
 *                                  "type"="object",
 *                                  "properties"={
 *                                      "url"={
 *                                          "description"="url",
 *                                          "type"="string"
 *                                      },
 *                                      "club"={
 *                                          "description"="club id",
 *                                          "type"="integer"
 *                                      },
 *                                      "email"={
 *                                          "description"="coach email",
 *                                          "type"="string"
 *                                      }
 *                                  }
 *                              },
 *                              "required"={"url","club", "email"}
 *                          }
 *                      }
 *                  },
 *                  "responses"={
 *                      "200"={"description"="success true"},
 *                      "400"={
 *                          "description"="Un utilisateur existe déjà pour cette adresse email ou L'adresse email n'est pas valide ou L'adresse email est obligatoire"
 *                      }
 *                  }
 *              }
 *          },
 *          "sendEmailPlayer"={
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "method"="post",
 *              "path"="/emailPlayer",
 *              "controller"="App\Controller\MailerRegisterPlayerController",
 *              "openapi_context"={
 *                  "summary"="invite a player to join a club",
 *                  "description"="send an email with a unique token for registration",
 *                  "parameters"={
 *                      {
 *                          "in"="query",
 *                          "name"="url",
 *                          "schema"={"type"="string"},
 *                          "required"="true"
 *                      },
 *                      {
 *                          "in"="query",
 *                          "name"="club",
 *                          "schema"={"type"="integer"},
 *                          "required"="true",
 *                          "description"="club id"
 *                      },
 *                      {
 *                          "in"="query",
 *                          "name"="email",
 *                          "schema"={"type"="string"},
 *                          "required"="true",
 *                          "description"="email player"
 *                      }
 *                  },
 *                  "requestBody"={
 *                      "content"={
 *                          "application/json"={
 *                              "schema"={
 *                                  "type"="object",
 *                                  "properties"={
 *                                      "url"={
 *                                          "description"="url",
 *                                          "type"="string"
 *                                      },
 *                                      "club"={
 *                                          "description"="club id",
 *                                          "type"="integer"
 *                                      },
 *                                      "email"={
 *                                          "description"="player email",
 *                                          "type"="string"
 *                                      }
 *                                  }
 *                              },
 *                              "required"={"url","club", "email"}
 *                          }
 *                      }
 *                  },
 *                  "responses"={
 *                      "200"={"description"="success true"},
 *                      "400"={
 *                          "description"="Un utilisateur existe déjà pour cette adresse email ou L'adresse email n'est pas valide ou L'adresse email est obligatoire"
 *                      }
 *                  }
 *              }
 *          }
 *     }
 * )
 */
class Admin
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"admins_read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="admins", cascade={"persist", "remove"}))
     * @ORM\JoinColumn(nullable=false)
     * @ORM\JoinColumn(onDelete="SET NULL")
     * @Groups({"admins_read"})
     * @Assert\NotBlank(message="les informations de l'utilisateur sont obligatoires")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
