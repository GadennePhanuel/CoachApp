<?php

namespace App\Entity;

use App\Entity\User;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ClubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=ClubRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"clubs_read"}},
 *     denormalizationContext={"disable_type_enforcement"=true},
 *     collectionOperations={"POST"={"security"="is_granted('ROLE_ADMIN')"}},
 *     itemOperations={
 *          "GET",
 *          "PUT"={"security"="is_granted('ROLE_ADMIN')"},
 *          "DELETE"={"security"="is_granted('ROLE_ADMIN')"}
 *     }
 * )
 */
class Club
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"clubs_read", "users_read", "admins_read", "coachs_read", "players_read", "trainings_read", "tactics_read", "encounters_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=75)
     * @Groups({"clubs_read", "users_read", "admins_read", "coachs_read", "players_read", "trainings_read", "tactics_read", "encounters_read"})
     * @Assert\NotBlank(message="le label est obligatoire")
     * @Assert\Type(type="string", message="le label doit être du texte")
     * @Assert\Length(min="3", max="50", minMessage="le nom du club doit faire entre 3 et 50 caractéres", maxMessage="le nom du club doit faire entre 3 et 50 caractéres")
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="club", orphanRemoval=true)
     * @Groups({"clubs_read"})
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Team::class, mappedBy="club", orphanRemoval=true)
     * @Groups({"clubs_read"})
     */
    private $teams;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->teams = new ArrayCollection();
    }

    /**
     * allows to return the number of coach and player in a team
     * @Groups({"clubs_read"})
     * @return int[]
     */
    public function getTotalByRoles(): array {
        $totalByRole = array("nbCoaches" => 0, "nbPlayers" => 0);
        foreach($this->getusers()->toArray() as $user){
            $roles = $user->getRoles();
            if($roles[0] == "ROLE_COACH"){
                $totalByRole["nbCoaches"] ++;
            }
            else if ($roles[0] == "ROLE_PLAYER"){
                $totalByRole["nbPlayers"] ++;
            }
        }
        return $totalByRole;
    }

    /**
     * permet de retourner le nombre d'équipe d'un club
     * @Groups({"clubs_read"})
     * @return int
     */
    public function getTotalTeams(): int {
        return count($this->getTeams()->toArray());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel($label): self
    {

        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setClub($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getClub() === $this) {
                $user->setClub(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Team[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
            $team->setClub($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
            // set the owning side to null (unless already changed)
            if ($team->getClub() === $this) {
                $team->setClub(null);
            }
        }

        return $this;
    }
}
