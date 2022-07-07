<?php

namespace App\Entity;

use App\Repository\RoomParticipantsInvitationsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomParticipantsInvitationsRepository::class)
 */
class RoomParticipantsInvitations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=EventRooms::class, inversedBy="roomParticipantsInvitations")
     */
    private $room;

    /**
     * @ORM\ManyToOne(targetEntity=Participant::class, inversedBy="roomParticipantsInvitations")
     */
    private $participant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoom(): ?EventRooms
    {
        return $this->room;
    }

    public function setRoom(?EventRooms $room): self
    {
        $this->room = $room;

        return $this;
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
}
