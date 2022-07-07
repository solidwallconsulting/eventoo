<?php

namespace App\Entity;

use App\Repository\SessionMeetingsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionMeetingsRepository::class)
 */
class SessionMeetings
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Participant::class, inversedBy="sessionMeetings")
     */
    private $main;

    /**
     * @ORM\ManyToOne(targetEntity=Participant::class, inversedBy="sessionMeetings")
     */
    private $second;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\ManyToOne(targetEntity=MeetingSessions::class, inversedBy="sessionMeetings")
     */
    private $session;

    /**
     * @ORM\Column(type="integer")
     */
    private $orderCreation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $uniqueID;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tableNumber;

    /**
     * @ORM\Column(type="integer")
     */
    private $presence;

    /**
     * @ORM\Column(type="integer")
     */
    private $realisation;



    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMain(): ?Participant
    {
        return $this->main;
    }

    public function setMain(?Participant $main): self
    {
        $this->main = $main;

        return $this;
    }

    public function getSecond(): ?Participant
    {
        return $this->second;
    }

    public function setSecond(?Participant $second): self
    {
        $this->second = $second;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getSession(): ?MeetingSessions
    {
        return $this->session;
    }

    public function setSession(?MeetingSessions $session): self
    {
        $this->session = $session;

        return $this;
    }

    public function getOrderCreation(): ?int
    {
        return $this->orderCreation;
    }

    public function setOrderCreation(int $orderCreation): self
    {
        $this->orderCreation = $orderCreation;

        return $this;
    }

    public function getUniqueID(): ?string
    {
        return $this->uniqueID;
    }

    public function setUniqueID(string $uniqueID): self
    {
        $this->uniqueID = $uniqueID;

        return $this;
    }

    public function getTableNumber(): ?int
    {
        return $this->tableNumber;
    }

    public function setTableNumber(?int $tableNumber): self
    {
        $this->tableNumber = $tableNumber;

        return $this;
    }

    public function getPresence(): ?int
    {
        return $this->presence;
    }

    public function setPresence(int $presence): self
    {
        $this->presence = $presence;

        return $this;
    }

    public function getRealisation(): ?int
    {
        return $this->realisation;
    }

    public function setRealisation(int $realisation): self
    {
        $this->realisation = $realisation;

        return $this;
    }
}
