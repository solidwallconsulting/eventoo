<?php

namespace App\Entity;

use App\Repository\EventStandsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventStandsRepository::class)
 */
class EventStands
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

 

    /**
     * @ORM\ManyToOne(targetEntity=Events::class, inversedBy="eventStands")
     */
    private $event;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $providername;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $providerEmail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $providerTitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $tags = [];

    /**
     * @ORM\ManyToOne(targetEntity=EventStandMesures::class, inversedBy="eventStands")
     */
    private $mesure;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkedIn;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $instagram;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebook;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $canEditParams;

    /**
     * @ORM\ManyToOne(targetEntity=Participant::class, inversedBy="eventStands")
     */
    private $Participant;

    /**
     * @ORM\OneToMany(targetEntity=StandProduct::class, mappedBy="stand")
     */
    private $standProducts;

    /**
     * @ORM\OneToMany(targetEntity=StandCatalogue::class, mappedBy="stand")
     */
    private $standCatalogues;

    /**
     * @ORM\OneToMany(targetEntity=StandVideos::class, mappedBy="stand")
     */
    private $standVideos;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numberID;

    public function __construct()
    {
        $this->standProducts = new ArrayCollection();
        $this->standCatalogues = new ArrayCollection();
        $this->standVideos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

 

    public function getEvent(): ?Events
    {
        return $this->event;
    }

    public function setEvent(?Events $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getProvidername(): ?string
    {
        return $this->providername;
    }

    public function setProvidername(string $providername): self
    {
        $this->providername = $providername;

        return $this;
    }

    public function getProviderEmail(): ?string
    {
        return $this->providerEmail;
    }

    public function setProviderEmail(string $providerEmail): self
    {
        $this->providerEmail = $providerEmail;

        return $this;
    }

    public function getProviderTitle(): ?string
    {
        return $this->providerTitle;
    }

    public function setProviderTitle(string $providerTitle): self
    {
        $this->providerTitle = $providerTitle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(?array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getMesure(): ?EventStandMesures
    {
        return $this->mesure;
    }

    public function setMesure(?EventStandMesures $mesure): self
    {
        $this->mesure = $mesure;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getLinkedIn(): ?string
    {
        return $this->linkedIn;
    }

    public function setLinkedIn(?string $linkedIn): self
    {
        $this->linkedIn = $linkedIn;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): self
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getCanEditParams(): ?bool
    {
        return $this->canEditParams;
    }

    public function setCanEditParams(?bool $canEditParams): self
    {
        $this->canEditParams = $canEditParams;

        return $this;
    }

    public function getParticipant(): ?Participant
    {
        return $this->Participant;
    }

    public function setParticipant(?Participant $Participant): self
    {
        $this->Participant = $Participant;

        return $this;
    }

    /**
     * @return Collection|StandProduct[]
     */
    public function getStandProducts(): Collection
    {
        return $this->standProducts;
    }

    public function addStandProduct(StandProduct $standProduct): self
    {
        if (!$this->standProducts->contains($standProduct)) {
            $this->standProducts[] = $standProduct;
            $standProduct->setStand($this);
        }

        return $this;
    }

    public function removeStandProduct(StandProduct $standProduct): self
    {
        if ($this->standProducts->removeElement($standProduct)) {
            // set the owning side to null (unless already changed)
            if ($standProduct->getStand() === $this) {
                $standProduct->setStand(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|StandCatalogue[]
     */
    public function getStandCatalogues(): Collection
    {
        return $this->standCatalogues;
    }

    public function addStandCatalogue(StandCatalogue $standCatalogue): self
    {
        if (!$this->standCatalogues->contains($standCatalogue)) {
            $this->standCatalogues[] = $standCatalogue;
            $standCatalogue->setStand($this);
        }

        return $this;
    }

    public function removeStandCatalogue(StandCatalogue $standCatalogue): self
    {
        if ($this->standCatalogues->removeElement($standCatalogue)) {
            // set the owning side to null (unless already changed)
            if ($standCatalogue->getStand() === $this) {
                $standCatalogue->setStand(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|StandVideos[]
     */
    public function getStandVideos(): Collection
    {
        return $this->standVideos;
    }

    public function addStandVideo(StandVideos $standVideo): self
    {
        if (!$this->standVideos->contains($standVideo)) {
            $this->standVideos[] = $standVideo;
            $standVideo->setStand($this);
        }

        return $this;
    }

    public function removeStandVideo(StandVideos $standVideo): self
    {
        if ($this->standVideos->removeElement($standVideo)) {
            // set the owning side to null (unless already changed)
            if ($standVideo->getStand() === $this) {
                $standVideo->setStand(null);
            }
        }

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getNumberID(): ?string
    {
        return $this->numberID;
    }

    public function setNumberID(string $numberID): self
    {
        $this->numberID = $numberID;

        return $this;
    }
}
