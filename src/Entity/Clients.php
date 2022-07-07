<?php

namespace App\Entity;

use App\Repository\ClientsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientsRepository::class)
 */
class Clients
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $clientName;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $civility;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $functionnality;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $countryIndex;


 

    /**
     * @ORM\OneToMany(targetEntity=Notes::class, mappedBy="client")
     */
    private $notes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logoURL;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="clients", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Events::class, mappedBy="client")
     */
    private $events;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    public function setClientName(string $clientName): self
    {
        $this->clientName = $clientName;

        return $this;
    }

    public function getPhotoURL(): ?string
    {
        return $this->photoURL;
    }

    public function setPhotoURL(string $photoURL): self
    {
        $this->photoURL = $photoURL;

        return $this;
    }

    public function getCivility(): ?string
    {
        return $this->civility;
    }

    public function setCivility(string $civility): self
    {
        $this->civility = $civility;

        return $this;
    }


    public function getFunctionnality(): ?string
    {
        return $this->functionnality;
    }

    public function setFunctionnality(string $functionnality): self
    {
        $this->functionnality = $functionnality;

        return $this;
    }

    public function getCountryIndex(): ?string
    {
        return $this->countryIndex;
    }

    public function setCountryIndex(string $countryIndex): self
    {
        $this->countryIndex = $countryIndex;

        return $this;
    }


 

    /**
     * @return Collection|Notes[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Notes $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setClient($this);
        }

        return $this;
    }

    public function removeNote(Notes $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getClient() === $this) {
                $note->setClient(null);
            }
        }

        return $this;
    }

    public function getLogoURL(): ?string
    {
        return $this->logoURL;
    }

    public function setLogoURL(string $logoURL): self
    {
        $this->logoURL = $logoURL;

        return $this;
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

    /**
     * @return Collection|Events[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Events $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setClient($this);
        }

        return $this;
    }

    public function removeEvent(Events $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getClient() === $this) {
                $event->setClient(null);
            }
        }

        return $this;
    }
}
