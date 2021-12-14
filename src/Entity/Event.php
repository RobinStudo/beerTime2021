<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Vous devez saisir un nom pour l'événement")
     * @Assert\Length(
     *      min=3,
     *      max=60,
     *      minMessage="Le nom doit contenir au minimum {{ limit }} caractères",
     *      maxMessage="Le nom doit contenir au maximum {{ limit }} caractères"
     * )
     * @ORM\Column(type="string", length=60)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picture;

    /**
     * @Assert\Url(message="Vous devez saisir une URL valide")
     */
    private $pictureUrl;

    /**
     * @Assert\Expression(
     *     "this.getPictureUrl() or this.getPictureFIle()",
     *     message="Vous devez importer une image ou fournir une URL"
     * )
     * @Assert\File(
     *     maxSize="2M",
     *     mimeTypes={"image/jpeg", "image/png"},
     *     maxSizeMessage="Les imports sont limités à {{ limit }}{{ suffix }}",
     *     mimeTypesMessage="Les imports sont limités au JPEG et PNG"
     * )
     */
    private $pictureFile;

    /**
     * @Assert\NotBlank(message="Vous devez saisir une description pour l'événement")
     * @Assert\Length(
     *      min=10,
     *      max=1500,
     *      minMessage="La description doit contenir au minimum {{ limit }} caractères",
     *      maxMessage="La description doit contenir au maximum {{ limit }} caractères"
     * )
    * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @Assert\NotBlank(message="Vous devez saisir une date de début")
     * @Assert\GreaterThan("now", message="Vous devez saisir une date de début supérieur à la date actuelle")
     * @ORM\Column(type="datetime")
     */
    private $startAt;

    /**
     * @Assert\NotBlank(message="Vous devez saisir une date de fin")
     * @Assert\GreaterThan(propertyPath="startAt", message="Vous devez saisir une date de fin supérieur à la date de début")
     * @ORM\Column(type="datetime")
     */
    private $endAt;

    /**
     * @Assert\Range(
     *     min=5,
     *     max=500,
     *     notInRangeMessage="Le prix minimum est de {{ min }}€, pour un événement gratuit laisser le champ vide. Pour des événements avec un prix supérieur à {{ max }}€, veuillez contacter notre équipe.",
     * )
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @Assert\Positive(message="Vous devez saisir une capacité positive ou laisser le champ vide pour ne pas imposer de limite")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $capacity;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @Assert\Valid()
     * @ORM\ManyToOne(targetEntity=Place::class, inversedBy="events", cascade={"persist"})
     */
    private $place;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ownedEvents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\ManyToMany(targetEntity=Rule::class)
     */
    private $rules;

    public function __construct()
    {
        $this->rules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
    }

    public function setPictureFile(?File $pictureFile): self
    {
        $this->pictureFile = $pictureFile;

        return $this;
    }

    public function getPictureUrl(): ?string
    {
        return $this->pictureUrl;
    }

    public function setPictureUrl(string $pictureUrl): self
    {
        $this->pictureUrl = $pictureUrl;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(?\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(?int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getRules(): Collection
    {
        return $this->rules;
    }

    public function addRule(Rule $rule): self
    {
        if (!$this->rules->contains($rule)) {
            $this->rules[] = $rule;
        }

        return $this;
    }

    public function removeRule(Rule $rule): self
    {
        $this->rules->removeElement($rule);

        return $this;
    }
}
