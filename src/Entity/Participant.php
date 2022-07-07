<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipantRepository::class)
 */
class Participant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=EventProfiles::class, inversedBy="participants")
     */
    private $profile;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=ParticipantFeildsImages::class, mappedBy="participant")
     */
    private $participantFeildsImages;

    /**
     * @ORM\OneToMany(targetEntity=RoomParticipantsInvitations::class, mappedBy="participant")
     */
    private $roomParticipantsInvitations;

    /**
     * @ORM\OneToMany(targetEntity=EventStands::class, mappedBy="Participant")
     */
    private $eventStands;

    /**
     * @ORM\OneToMany(targetEntity=RoomSessionAccess::class, mappedBy="participant")
     */
    private $roomSessionAccesses;

    /**
     * @ORM\ManyToOne(targetEntity=SubProfile::class, inversedBy="participants")
     */
    private $subProfile;

    /**
     * @ORM\OneToMany(targetEntity=SessionMeetings::class, mappedBy="main")
     */
    private $sessionMeetings;

    public function __construct()
    {
        $this->participantFeildsImages = new ArrayCollection();
        $this->roomParticipantsInvitations = new ArrayCollection();
        $this->eventStands = new ArrayCollection();
        $this->roomSessionAccesses = new ArrayCollection();
        $this->sessionMeetings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfile(): ?EventProfiles
    {
        return $this->profile;
    }

    public function setProfile(?EventProfiles $profile): self
    {
        $this->profile = $profile;

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
     * @return Collection|ParticipantFeildsImages[]
     */
    public function getParticipantFeildsImages(): Collection
    {
        return $this->participantFeildsImages;
    }

    public function addParticipantFeildsImage(ParticipantFeildsImages $participantFeildsImage): self
    {
        if (!$this->participantFeildsImages->contains($participantFeildsImage)) {
            $this->participantFeildsImages[] = $participantFeildsImage;
            $participantFeildsImage->setParticipant($this);
        }

        return $this;
    }

    public function removeParticipantFeildsImage(ParticipantFeildsImages $participantFeildsImage): self
    {
        if ($this->participantFeildsImages->removeElement($participantFeildsImage)) {
            // set the owning side to null (unless already changed)
            if ($participantFeildsImage->getParticipant() === $this) {
                $participantFeildsImage->setParticipant(null);
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
            $roomParticipantsInvitation->setParticipant($this);
        }

        return $this;
    }

    public function removeRoomParticipantsInvitation(RoomParticipantsInvitations $roomParticipantsInvitation): self
    {
        if ($this->roomParticipantsInvitations->removeElement($roomParticipantsInvitation)) {
            // set the owning side to null (unless already changed)
            if ($roomParticipantsInvitation->getParticipant() === $this) {
                $roomParticipantsInvitation->setParticipant(null);
            }
        }

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
            $eventStand->setParticipant($this);
        }

        return $this;
    }

    public function removeEventStand(EventStands $eventStand): self
    {
        if ($this->eventStands->removeElement($eventStand)) {
            // set the owning side to null (unless already changed)
            if ($eventStand->getParticipant() === $this) {
                $eventStand->setParticipant(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
        return $this->user->getFirstname().' '.$this->user->getLastname();
    }

    public function standName()
    {
        return $this->user->getFirstname().' '.$this->user->getLastname().' - '.$this->getProfile()->getLabel();
    }

    

    /**
     * @return Collection|RoomSessionAccess[]
     */
    public function getRoomSessionAccesses(): Collection
    {
        return $this->roomSessionAccesses;
    }

    public function addRoomSessionAccess(RoomSessionAccess $roomSessionAccess): self
    {
        if (!$this->roomSessionAccesses->contains($roomSessionAccess)) {
            $this->roomSessionAccesses[] = $roomSessionAccess;
            $roomSessionAccess->setParticipant($this);
        }

        return $this;
    }

    public function removeRoomSessionAccess(RoomSessionAccess $roomSessionAccess): self
    {
        if ($this->roomSessionAccesses->removeElement($roomSessionAccess)) {
            // set the owning side to null (unless already changed)
            if ($roomSessionAccess->getParticipant() === $this) {
                $roomSessionAccess->setParticipant(null);
            }
        }

        return $this;
    }

    public function getSubProfile(): ?SubProfile
    {
        return $this->subProfile;
    }

    public function setSubProfile(?SubProfile $subProfile): self
    {
        $this->subProfile = $subProfile;

        return $this;
    }

    /**
     * @return Collection|SessionMeetings[]
     */
    public function getSessionMeetings(): Collection
    {
        return $this->sessionMeetings;
    }

    public function addSessionMeeting(SessionMeetings $sessionMeeting): self
    {
        if (!$this->sessionMeetings->contains($sessionMeeting)) {
            $this->sessionMeetings[] = $sessionMeeting;
            $sessionMeeting->setMain($this);
        }

        return $this;
    }

    public function removeSessionMeeting(SessionMeetings $sessionMeeting): self
    {
        if ($this->sessionMeetings->removeElement($sessionMeeting)) {
            // set the owning side to null (unless already changed)
            if ($sessionMeeting->getMain() === $this) {
                $sessionMeeting->setMain(null);
            }
        }

        return $this;
    } 
}
