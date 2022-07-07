<?php

namespace App\Entity;

use App\Repository\RoomSessionAccessRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomSessionAccessRepository::class)
 */
class RoomSessionAccess
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Participant::class, inversedBy="roomSessionAccesses")
     */
    private $participant; 

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $invitations;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $confirmedMeetings;

    /**
     * @ORM\ManyToOne(targetEntity=BtBMeetingRoom::class, inversedBy="roomSessionAccesses")
     */
    private $roomBTB;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParticipant(): ?Participant
    {
        return $this->participant;
    }

    public function setParticipant(?Participant $participant): self
    {
        $this->participant = $participant;

        return $this;
    }

 

    public function getInvitations(): ?int
    {
        return $this->invitations;
    }

    public function setInvitations(?int $invitations): self
    {
        $this->invitations = $invitations;

        return $this;
    }

    public function getConfirmedMeetings(): ?int
    {
        return $this->confirmedMeetings;
    }

    public function setConfirmedMeetings(?int $confirmedMeetings): self
    {
        $this->confirmedMeetings = $confirmedMeetings;

        return $this;
    }

    public function getRoomBTB(): ?BtBMeetingRoom
    {
        return $this->roomBTB;
    }

    public function setRoomBTB(?BtBMeetingRoom $roomBTB): self
    {
        $this->roomBTB = $roomBTB;

        return $this;
    }
}
