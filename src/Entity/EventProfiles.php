<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 */
class EventProfiles
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
    private $tarification;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descreption;

    /**
     * @ORM\Column(type="integer")
     */
    private $participantsNumber;

    /**
     * @ORM\ManyToOne(targetEntity=Events::class, inversedBy="eventProfiles")
     */
    private $event;

    /**
     * @ORM\OneToMany(targetEntity=EventAssociatedProfileFeilds::class, mappedBy="profile")
     */
    private $eventAssociatedProfileFeilds;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $uniqueID;

    /**
     * @ORM\OneToMany(targetEntity=Participant::class, mappedBy="profile")
     */
    private $participants;

    /**
     * @ORM\OneToMany(targetEntity=RoomAccessProfiles::class, mappedBy="profile")
     */
    private $roomAccessProfiles;

    /**
     * @ORM\OneToMany(targetEntity=SubProfile::class, mappedBy="profile")
     */
    private $subProfiles;

 

    public function __construct()
    {
        $this->eventAssociatedProfileFeilds = new ArrayCollection();
        $this->participants = new ArrayCollection();
        $this->roomAccessProfiles = new ArrayCollection();
        $this->subProfiles = new ArrayCollection();
      
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

    public function getTarification(): ?string
    {
        return $this->tarification;
    }

    public function setTarification(string $tarification): self
    {
        $this->tarification = $tarification;

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

    public function getDescreption(): ?string
    {
        return $this->descreption;
    }

    public function setDescreption(?string $descreption): self
    {
        $this->descreption = $descreption;

        return $this;
    }

    public function getParticipantsNumber(): ?int
    {
        return $this->participantsNumber;
    }

    public function setParticipantsNumber(int $participantsNumber): self
    {
        $this->participantsNumber = $participantsNumber;

        return $this;
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

    /**
     * @return Collection|EventAssociatedProfileFeilds[]
     */
    public function getEventAssociatedProfileFeilds(): Collection
    {
        return $this->eventAssociatedProfileFeilds;
    }

    public function addEventAssociatedProfileFeild(EventAssociatedProfileFeilds $eventAssociatedProfileFeild): self
    {
        if (!$this->eventAssociatedProfileFeilds->contains($eventAssociatedProfileFeild)) {
            $this->eventAssociatedProfileFeilds[] = $eventAssociatedProfileFeild;
            $eventAssociatedProfileFeild->setProfile($this);
        }

        return $this;
    }

    public function removeEventAssociatedProfileFeild(EventAssociatedProfileFeilds $eventAssociatedProfileFeild): self
    {
        if ($this->eventAssociatedProfileFeilds->removeElement($eventAssociatedProfileFeild)) {
            // set the owning side to null (unless already changed)
            if ($eventAssociatedProfileFeild->getProfile() === $this) {
                $eventAssociatedProfileFeild->setProfile(null);
            }
        }

        return $this;
    }

    public function getUniqueID(): ?string
    {
        return $this->uniqueID;
    }

    public function setUniqueID(?string $uniqueID): self
    {
        $this->uniqueID = $uniqueID;

        return $this;
    }

    /**
     * @return Collection|Participant[]
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->setProfile($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): self
    {
        if ($this->participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getProfile() === $this) {
                $participant->setProfile(null);
            }
        }

        return $this;
    }

 
    public function __toString(){
        return $this->label;
    }

    /**
     * @return Collection|RoomAccessProfiles[]
     */
    public function getRoomAccessProfiles(): Collection
    {
        return $this->roomAccessProfiles;
    }

    public function addRoomAccessProfile(RoomAccessProfiles $roomAccessProfile): self
    {
        if (!$this->roomAccessProfiles->contains($roomAccessProfile)) {
            $this->roomAccessProfiles[] = $roomAccessProfile;
            $roomAccessProfile->setProfile($this);
        }

        return $this;
    }

    public function removeRoomAccessProfile(RoomAccessProfiles $roomAccessProfile): self
    {
        if ($this->roomAccessProfiles->removeElement($roomAccessProfile)) {
            // set the owning side to null (unless already changed)
            if ($roomAccessProfile->getProfile() === $this) {
                $roomAccessProfile->setProfile(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SubProfile[]
     */
    public function getSubProfiles(): Collection
    {
        return $this->subProfiles;
    }

    public function addSubProfile(SubProfile $subProfile): self
    {
        if (!$this->subProfiles->contains($subProfile)) {
            $this->subProfiles[] = $subProfile;
            $subProfile->setProfile($this);
        }

        return $this;
    }

    public function removeSubProfile(SubProfile $subProfile): self
    {
        if ($this->subProfiles->removeElement($subProfile)) {
            // set the owning side to null (unless already changed)
            if ($subProfile->getProfile() === $this) {
                $subProfile->setProfile(null);
            }
        }

        return $this;
    }

    

    
 
}
