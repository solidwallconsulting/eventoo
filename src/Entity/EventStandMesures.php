<?php

namespace App\Entity;

use App\Repository\EventStandMesuresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventStandMesuresRepository::class)
 */
class EventStandMesures
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
    private $meusure;

    /**
     * @ORM\OneToMany(targetEntity=EventStands::class, mappedBy="mesure")
     */
    private $eventStands;

    public function __construct()
    {
        $this->eventStands = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMeusure(): ?string
    {
        return $this->meusure;
    }

    public function setMeusure(string $meusure): self
    {
        $this->meusure = $meusure;

        return $this;
    }

    /**
     * @return Collection|EventStands[]
     */
    public function getEventStands(): Collection
    {
        return $this->eventStands;
    }

    public function addEventStand(EventStands $eventStand): self
    {
        if (!$this->eventStands->contains($eventStand)) {
            $this->eventStands[] = $eventStand;
            $eventStand->setMesure($this);
        }

        return $this;
    }

    public function removeEventStand(EventStands $eventStand): self
    {
        if ($this->eventStands->removeElement($eventStand)) {
            // set the owning side to null (unless already changed)
            if ($eventStand->getMesure() === $this) {
                $eventStand->setMesure(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
      return $this->meusure;  
    } 
}
