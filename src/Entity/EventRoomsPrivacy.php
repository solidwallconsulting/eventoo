<?php

namespace App\Entity;

use App\Repository\EventRoomsPrivacyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRoomsPrivacyRepository::class)
 */
class EventRoomsPrivacy
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
    private $label;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $labelEn;

    /**
     * @ORM\OneToMany(targetEntity=EventRooms::class, mappedBy="privacy")
     */
    private $eventRooms;

    public function __construct()
    {
        $this->eventRooms = new ArrayCollection();
    }

 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getLabelEn(): ?string
    {
        return $this->labelEn;
    }

    public function setLabelEn(string $labelEn): self
    {
        $this->labelEn = $labelEn;

        return $this;
    }

    /**
     * @return Collection|EventRooms[]
     */
    public function getEventRooms(): Collection
    {
        return $this->eventRooms;
    }

    public function addEventRoom(EventRooms $eventRoom): self
    {
        if (!$this->eventRooms->contains($eventRoom)) {
            $this->eventRooms[] = $eventRoom;
            $eventRoom->setPrivacy($this);
        }

        return $this;
    }

    public function removeEventRoom(EventRooms $eventRoom): self
    {
        if ($this->eventRooms->removeElement($eventRoom)) {
            // set the owning side to null (unless already changed)
            if ($eventRoom->getPrivacy() === $this) {
                $eventRoom->setPrivacy(null);
            }
        }

        return $this;
    }

 
}
