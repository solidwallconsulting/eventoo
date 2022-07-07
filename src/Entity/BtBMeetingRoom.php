<?php

namespace App\Entity;

use App\Repository\BtBMeetingRoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BtBMeetingRoomRepository::class)
 */
class BtBMeetingRoom
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $theme;


    /**
     * @ORM\Column(type="integer")
     */
    private $state;

    /**
     * @ORM\Column(type="integer")
     */
    private $maximumInvitationNumber;

    /**
     * @ORM\ManyToOne(targetEntity=Events::class, inversedBy="btBMeetingRooms")
     */
    private $event;

    /**
     * @ORM\OneToMany(targetEntity=MeetingSessions::class, mappedBy="room")
     */
    private $meetingSessions;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $meet;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbrOfConfirmedMeetingPerMember;

    /**
     * @ORM\Column(type="integer")
     */
    private $access;

    /**
     * @ORM\OneToMany(targetEntity=RoomSessionAccess::class, mappedBy="roomBTB")
     */
    private $roomSessionAccesses;

    /**
     * @ORM\OneToMany(targetEntity=AppointmentRequest::class, mappedBy="roomBtB")
     */
    private $appointmentRequests;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $invitationsState;

    public function __construct()
    {
        $this->meetingSessions = new ArrayCollection();
        $this->roomSessionAccesses = new ArrayCollection();
        $this->appointmentRequests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(?string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }


    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getMaximumInvitationNumber(): ?int
    {
        return $this->maximumInvitationNumber;
    }

    public function setMaximumInvitationNumber(int $maximumInvitationNumber): self
    {
        $this->maximumInvitationNumber = $maximumInvitationNumber;

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
     * @return Collection|MeetingSessions[]
     */
    public function getMeetingSessions(): Collection
    {
        return $this->meetingSessions;
    }

    public function addMeetingSession(MeetingSessions $meetingSession): self
    {
        if (!$this->meetingSessions->contains($meetingSession)) {
            $this->meetingSessions[] = $meetingSession;
            $meetingSession->setRoom($this);
        }

        return $this;
    }

    public function removeMeetingSession(MeetingSessions $meetingSession): self
    {
        if ($this->meetingSessions->removeElement($meetingSession)) {
            // set the owning side to null (unless already changed)
            if ($meetingSession->getRoom() === $this) {
                $meetingSession->setRoom(null);
            }
        }

        return $this;
    }

 
    public function __toString()
    {
       return $this->getMeet(); 
    }

    public function getMeet(): ?string
    {
        return $this->meet;
    }

    public function setMeet(?string $meet): self
    {
        $this->meet = $meet;

        return $this;
    }

    public function getNbrOfConfirmedMeetingPerMember(): ?int
    {
        return $this->nbrOfConfirmedMeetingPerMember;
    }

    public function setNbrOfConfirmedMeetingPerMember(?int $nbrOfConfirmedMeetingPerMember): self
    {
        $this->nbrOfConfirmedMeetingPerMember = $nbrOfConfirmedMeetingPerMember;

        return $this;
    }

    public function getAccess(): ?int
    {
        return $this->access;
    }

    public function setAccess(int $access): self
    {
        $this->access = $access;

        return $this;
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
            $roomSessionAccess->setRoomBTB($this);
        }

        return $this;
    }

    public function removeRoomSessionAccess(RoomSessionAccess $roomSessionAccess): self
    {
        if ($this->roomSessionAccesses->removeElement($roomSessionAccess)) {
            // set the owning side to null (unless already changed)
            if ($roomSessionAccess->getRoomBTB() === $this) {
                $roomSessionAccess->setRoomBTB(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AppointmentRequest[]
     */
    public function getAppointmentRequests(): Collection
    {
        return $this->appointmentRequests;
    }

    public function addAppointmentRequest(AppointmentRequest $appointmentRequest): self
    {
        if (!$this->appointmentRequests->contains($appointmentRequest)) {
            $this->appointmentRequests[] = $appointmentRequest;
            $appointmentRequest->setRoomBtB($this);
        }

        return $this;
    }

    public function removeAppointmentRequest(AppointmentRequest $appointmentRequest): self
    {
        if ($this->appointmentRequests->removeElement($appointmentRequest)) {
            // set the owning side to null (unless already changed)
            if ($appointmentRequest->getRoomBtB() === $this) {
                $appointmentRequest->setRoomBtB(null);
            }
        }

        return $this;
    }

    public function getInvitationsState(): ?int
    {
        return $this->invitationsState;
    }

    public function setInvitationsState(?int $invitationsState): self
    {
        $this->invitationsState = $invitationsState;

        return $this;
    } 
}
