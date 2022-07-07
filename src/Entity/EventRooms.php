<?php

namespace App\Entity;

use App\Repository\EventRoomsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRoomsRepository::class)
 */
class EventRooms
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photoURL;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photoAlt;

   

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $maximumNumberOfParticipants;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $youtubeShare;

    /**
     * @ORM\ManyToOne(targetEntity=Events::class, inversedBy="eventRooms")
     */
    private $event;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $keyWords = [];

    /**
     * @ORM\ManyToOne(targetEntity=EventRoomsPrivacy::class, inversedBy="eventRooms")
     */
    private $privacy;

    /**
     * @ORM\OneToMany(targetEntity=RoomAccessProfiles::class, mappedBy="room")
     */
    private $roomAccessProfiles;

    /**
     * @ORM\OneToMany(targetEntity=RoomParticipantsInvitations::class, mappedBy="room")
     */
    private $roomParticipantsInvitations;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $workerProfiles = [];

    /**
     * @ORM\OneToMany(targetEntity=RoomProgramm::class, mappedBy="room")
     */
    private $roomProgramms;

    public function __construct()
    {
        $this->roomAccessProfiles = new ArrayCollection();
        $this->roomParticipantsInvitations = new ArrayCollection();
        $this->roomProgramms = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhotoURL(): ?string
    {
        return $this->photoURL;
    }

    public function setPhotoURL(?string $photoURL): self
    {
        $this->photoURL = $photoURL;

        return $this;
    }

    public function getPhotoAlt(): ?string
    {
        return $this->photoAlt;
    }

    public function setPhotoAlt(?string $photoAlt): self
    {
        $this->photoAlt = $photoAlt;

        return $this;
    }
 

    public function getMaximumNumberOfParticipants(): ?int
    {
        return $this->maximumNumberOfParticipants;
    }

    public function setMaximumNumberOfParticipants(?int $maximumNumberOfParticipants): self
    {
        $this->maximumNumberOfParticipants = $maximumNumberOfParticipants;

        return $this;
    }

    public function getYoutubeShare(): ?bool
    {
        return $this->youtubeShare;
    }

    public function setYoutubeShare(?bool $youtubeShare): self
    {
        $this->youtubeShare = $youtubeShare;

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

    public function getKeyWords(): ?array
    {
        return $this->keyWords;
    }

    public function setKeyWords(?array $keyWords): self
    {
        $this->keyWords = $keyWords;

        return $this;
    }

    public function getPrivacy(): ?EventRoomsPrivacy
    {
        return $this->privacy;
    }

    public function setPrivacy(?EventRoomsPrivacy $privacy): self
    {
        $this->privacy = $privacy;

        return $this;
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
            $roomAccessProfile->setRoom($this);
        }

        return $this;
    }

    public function removeRoomAccessProfile(RoomAccessProfiles $roomAccessProfile): self
    {
        if ($this->roomAccessProfiles->removeElement($roomAccessProfile)) {
            // set the owning side to null (unless already changed)
            if ($roomAccessProfile->getRoom() === $this) {
                $roomAccessProfile->setRoom(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RoomParticipantsInvitations[]
     */
    public function getRoomParticipantsInvitations(): Collection
    {
        return $this->roomParticipantsInvitations;
    }

    public function addRoomParticipantsInvitation(RoomParticipantsInvitations $roomParticipantsInvitation): self
    {
        if (!$this->roomParticipantsInvitations->contains($roomParticipantsInvitation)) {
            $this->roomParticipantsInvitations[] = $roomParticipantsInvitation;
            $roomParticipantsInvitation->setRoom($this);
        }

        return $this;
    }

    public function removeRoomParticipantsInvitation(RoomParticipantsInvitations $roomParticipantsInvitation): self
    {
        if ($this->roomParticipantsInvitations->removeElement($roomParticipantsInvitation)) {
            // set the owning side to null (unless already changed)
            if ($roomParticipantsInvitation->getRoom() === $this) {
                $roomParticipantsInvitation->setRoom(null);
            }
        }

        return $this;
    }

    public function getWorkerProfiles(): ?array
    {
        return $this->workerProfiles;
    }

    public function setWorkerProfiles(?array $workerProfiles): self
    {
        $this->workerProfiles = $workerProfiles;

        return $this;
    }

    /**
     * @return Collection|RoomProgramm[]
     */
    public function getRoomProgramms(): Collection
    {
        return $this->roomProgramms;
    }

    public function addRoomProgramm(RoomProgramm $roomProgramm): self
    {
        if (!$this->roomProgramms->contains($roomProgramm)) {
            $this->roomProgramms[] = $roomProgramm;
            $roomProgramm->setRoom($this);
        }

        return $this;
    }

    public function removeRoomProgramm(RoomProgramm $roomProgramm): self
    {
        if ($this->roomProgramms->removeElement($roomProgramm)) {
            // set the owning side to null (unless already changed)
            if ($roomProgramm->getRoom() === $this) {
                $roomProgramm->setRoom(null);
            }
        }

        return $this;
    }

 
 
}
