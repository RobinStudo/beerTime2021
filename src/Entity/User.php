<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("username", message="Ce nom d'utilisateur est déjà utilisé")
 * @UniqueEntity("email", message="Cette adresse e-mail est déjà rattaché à un compte")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Vous devez saisir un nom d'utilisateur")
     * @Assert\Length(
     *      min=3,
     *      max=20,
     *      minMessage="Votre nom d'utilisateur doit contenir au minimum {{ limit }} caractères",
     *      maxMessage="Votre nom d'utilisateur doit contenir au maximum {{ limit }} caractères"
     * )
     * @Assert\Regex("/^[a-zA-Z0-9_]*$/", message="Votre nom d'utilisateur doit contenir uniquement des caractères alphanumériques")
     * @ORM\Column(type="string", length=20)
     */
    private $username;

    /**
     * @Assert\NotBlank(message="Vous devez saisir une adresse e-mail")
     * @Assert\Email(message="Vous devez saisir une adresse e-mail valide", mode="strict")
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @Assert\NotBlank(message="Vous devez saisir un mot de passe")
     * @Assert\Length(
     *      min=8,
     *      max=40,
     *      minMessage="Votre mot de passe doit contenir au minimum {{ limit }} caractères",
     *      maxMessage="Votre mot de passe doit contenir au maximum {{ limit }} caractères"
     * )
     * @Assert\Regex("/^(?=.*[A-Za-z])(?=.*\d)(?=.*?[@$!%*#?&])/", message="Votre mot de passe doit au minmum contenir un chiffre, une lettre et un caractère spécial")
     * @Assert\NotCompromisedPassword(message="Ce mot de passe semble avoir déjà été compromis lors d'une fuite de donnée d'un autre service")
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @Assert\NotBlank(message="Vous devez renseigner votre date de naissance")
     * @Assert\LessThanOrEqual("-18 years", message="Vous devez être majeur pour accéder à notre plateforme")
     * @ORM\Column(type="date")
     */
    private $birthdate;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="owner")
     */
    private $ownedEvents;

    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="user", orphanRemoval=true)
     */
    private $bookings;

    public function __construct()
    {
        $this->ownedEvents = new ArrayCollection();
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getOwnedEvents(): Collection
    {
        return $this->ownedEvents;
    }

    public function addOwnedEvent(Event $ownedEvent): self
    {
        if (!$this->ownedEvents->contains($ownedEvent)) {
            $this->ownedEvents[] = $ownedEvent;
            $ownedEvent->setOwner($this);
        }

        return $this;
    }

    public function removeOwnedEvent(Event $ownedEvent): self
    {
        if ($this->ownedEvents->removeElement($ownedEvent)) {
            if ($ownedEvent->getOwner() === $this) {
                $ownedEvent->setOwner(null);
            }
        }

        return $this;
    }

    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setUser($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            if ($booking->getUser() === $this) {
                $booking->setUser(null);
            }
        }

        return $this;
    }

    public function eraseCredentials(){}

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
