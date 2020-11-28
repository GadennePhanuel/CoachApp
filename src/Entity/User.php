<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("email", message="cette email est déja utilisé")
 * @ApiResource(
 *    attributes={
            "order"={"lastName":"ASC", "firstName":"ASC"}
 *     },
 *     normalizationContext={
            "groups"={"users_read"}
 *     },
 *     denormalizationContext={
 *          "disable_type_enforcement"=true
 *     },
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"clubs_read", "users_read", "admins_read", "coachs_read", "players_read", "teams_read", "trainings_read", "trainingMisseds_read", "stats_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"clubs_read", "users_read", "admins_read", "coachs_read", "players_read", "teams_read", "trainings_read", "trainingMisseds_read"})
     * @Assert\NotBlank(message="l'email est obligatoire")
     * @Assert\Email(message="ce n'est pas un email valide")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"users_read", "clubs_read", "admins_read", "coachs_read", "players_read"})
     * @Assert\NotBlank(message="Role de l'utilisateur obligatoire")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Un mot de passe est obligatoire")
     * @Assert\Length(min="6", max="20", minMessage="le mot de passe doit faire entre 6 et 20 caractéres", maxMessage="le mot de passe doit faire entre 6 et 20 caractéres")
     * @Assert\Regex(pattern="/^(?=.*[a-z])(?=.*\d).{6,}$/i", message="le mot de passe doit comporter au moins 6 caractères et inclure au moins une lettre et un chiffre")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=75)
     * @Groups({"clubs_read", "users_read", "admins_read", "coachs_read", "players_read", "teams_read", "trainings_read", "trainingMisseds_read", "stats_read", "players_subresource", "encounters_read"})
     * @Assert\NotBlank(message="le nom de famille est obligatoire")
     * @Assert\Length(min="2", max="75", minMessage="le nom de famille doit faire entre 2 et 75 caractères", maxMessage="le nom de famille doit faire entre 2 et 75 caractères")
     *
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=75)
     * @Groups({"clubs_read", "users_read", "admins_read", "coachs_read", "players_read", "teams_read", "trainings_read", "trainingMisseds_read", "stats_read", "players_subresource", "encounters_read"})
     * @Assert\NotBlank(message="le prénom est obligatoire")
     * @Assert\Length(min="2", max="75", minMessage="le prénom doit faire entre 2 et 75 caractères", maxMessage="le prénom doit faire entre 2 et 75 caractères")
     */
    private $firstName;

    /**
     * @ORM\Column(type="date")
     * @Groups({"clubs_read", "users_read", "admins_read", "coachs_read", "players_read", "teams_read"})
     * @Assert\NotBlank(message="le date de naissance est obligatoire")
     * @Assert\Type(type="DateTime", message="la date doit être au format YYYY-MM-DD")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=15)
     * @Groups({"clubs_read", "users_read", "admins_read", "coachs_read", "players_read", "teams_read"})
     * @Assert\NotBlank(message="Un numéro de téléphone est obligatoire")
     * @Assert\Length(min=10, max=10, exactMessage="Le numéro doit faire exactement 10 chiffres")
     * @Assert\Regex(pattern="/^[0-9]*$/", message="nombre uniquement")
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity=Club::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"users_read", "admins_read", "coachs_read", "players_read", "stats_read"})
     */
    private $club;

    /**
     * @ORM\OneToMany(targetEntity=Admin::class, mappedBy="user", orphanRemoval=true)
     * @ORM\joinColumn(onDelete="SET NULL")
     */
    private $admins;

    /**
     * @ORM\OneToMany(targetEntity=Coach::class, mappedBy="user", orphanRemoval=true)
     * @ORM\joinColumn(onDelete="SET NULL")
     */
    private $coaches;

    /**
     * @ORM\OneToMany(targetEntity=Player::class, mappedBy="user", orphanRemoval=true)
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $players;

    public function __construct()
    {
        $this->admins = new ArrayCollection();
        $this->coaches = new ArrayCollection();
        $this->players = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday($birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getClub(): ?Club
    {
        return $this->club;
    }

    public function setClub(?Club $club): self
    {
        $this->club = $club;

        return $this;
    }

    /**
     * @return Collection|Admin[]
     */
    public function getAdmins(): Collection
    {
        return $this->admins;
    }

    public function addAdmin(Admin $admin): self
    {
        if (!$this->admins->contains($admin)) {
            $this->admins[] = $admin;
            $admin->setUser($this);
        }

        return $this;
    }

    public function removeAdmin(Admin $admin): self
    {
        if ($this->admins->contains($admin)) {
            $this->admins->removeElement($admin);
            // set the owning side to null (unless already changed)
            if ($admin->getUser() === $this) {
                $admin->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Coach[]
     */
    public function getCoaches(): Collection
    {
        return $this->coaches;
    }

    public function addCoach(Coach $coach): self
    {
        if (!$this->coaches->contains($coach)) {
            $this->coaches[] = $coach;
            $coach->setUser($this);
        }

        return $this;
    }

    public function removeCoach(Coach $coach): self
    {
        if ($this->coaches->contains($coach)) {
            $this->coaches->removeElement($coach);
            // set the owning side to null (unless already changed)
            if ($coach->getUser() === $this) {
                $coach->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Player[]
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
            $player->setUser($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->contains($player)) {
            $this->players->removeElement($player);
            // set the owning side to null (unless already changed)
            if ($player->getUser() === $this) {
                $player->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @param ArrayCollection $players
     */
    public function setPlayers(ArrayCollection $players): void
    {
        $this->players = $players;
    }


}
