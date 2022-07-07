<?php

namespace App\Entity;

use App\Repository\AppointmentRequestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AppointmentRequestRepository::class)
 */
class AppointmentRequest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="appointmentRequests")
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="appointmentRequests")
     */
    private $receiver;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $sendDate;

    /**
     * @ORM\ManyToOne(targetEntity=Events::class, inversedBy="appointmentRequests")
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity=BtBMeetingRoom::class, inversedBy="appointmentRequests")
     */
    private $roomBtB;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getReceiver(): ?User
    {
        return $this->receiver;
    }

    public function setReceiver(?User $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getSendDate(): ?\DateTimeInterface
    {
        return $this->sendDate;
    }

    public function setSendDate(?\DateTimeInterface $sendDate): self
    {
        $this->sendDate = $sendDate;

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

    public function getRoomBtB(): ?BtBMeetingRoom
    {
        return $this->roomBtB;
    }

    public function setRoomBtB(?BtBMeetingRoom $roomBtB): self
    {
        $this->roomBtB = $roomBtB;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
