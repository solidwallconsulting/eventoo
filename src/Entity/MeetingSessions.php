<?php

namespace App\Entity;

use App\Repository\MeetingSessionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MeetingSessionsRepository::class)
 */
class MeetingSessions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=BtBMeetingRoom::class, inversedBy="meetingSessions")
     */
    private $room;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $place;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateAndTime;

    /**
     * @ORM\Column(type="integer")
     */
    private $minutesPerRDV;

    /**
     * @ORM\ManyToOne(targetEntity=EventsLanguages::class, inversedBy="meetingSessions")
     */
    private $language;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $interpretation;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrTablesPerSession;

    /**
     * @ORM\Column(type="integer")
     */
    private $tableRotation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $matchmaking;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $byWho;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $accessebility;

    /**
     * @ORM\OneToMany(targetEntity=RoomSessionAccess::class, mappedBy="session")
     */
    private $roomSessionAccesses;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDateTime;

    /**
     * @ORM\OneToMany(targetEntity=SessionMeetings::class, mappedBy="session")
     */
    private $sessionMeetings;

    public function __construct()
    {
        $this->roomSessionAccesses = new ArrayCollection();
        $this->sessionMeetings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoom(): ?BtBMeetingRoom
    {
        return $this->room;
    }

    public function setRoom(?BtBMeetingRoom $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getDateAndTime(): ?\DateTimeInterface
    {
        return $this->dateAndTime;
    }

    public function setDateAndTime(?\DateTimeInterface $dateAndTime): self
    {
        $this->dateAndTime = $dateAndTime;

        return $this;
    }

    public function getMinutesPerRDV(): ?int
    {
        return $this->minutesPerRDV;
    }

    public function setMinutesPerRDV(int $minutesPerRDV): self
    {
        $this->minutesPerRDV = $minutesPerRDV;

        return $this;
    }

    public function getLanguage(): ?EventsLanguages
    {
        return $this->language;
    }

    public function setLanguage(?EventsLanguages $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getInterpretation(): ?bool
    {
        return $this->interpretation;
    }

    public function setInterpretation(?bool $interpretation): self
    {
        $this->interpretation = $interpretation;

        return $this;
    }

    public function getNbrTablesPerSession(): ?int
    {
        return $this->nbrTablesPerSession;
    }

    public function setNbrTablesPerSession(int $nbrTablesPerSession): self
    {
        $this->nbrTablesPerSession = $nbrTablesPerSession;

        return $this;
    }

    public function getTableRotation(): ?int
    {
        return $this->tableRotation;
    }

    public function setTableRotation(int $tableRotation): self
    {
        $this->tableRotation = $tableRotation;

        return $this;
    }

    public function getMatchmaking(): ?int
    {
        return $this->matchmaking;
    }

    public function setMatchmaking(?int $matchmaking): self
    {
        $this->matchmaking = $matchmaking;

        return $this;
    }

    public function getByWho(): ?int
    {
        return $this->byWho;
    }

    public function setByWho(?int $byWho): self
    {
        $this->byWho = $byWho;

        return $this;
    }

    public function getAccessebility(): ?int
    {
        return $this->accessebility;
    }

    public function setAccessebility(?int $accessebility): self
    {
        $this->accessebility = $accessebility;

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
            //$roomSessionAccess->setSession($this);
        }

        return $this;
    }

    public function removeRoomSessionAccess(RoomSessionAccess $roomSessionAccess): self
    {
        if ($this->roomSessionAccesses->removeElement($roomSessionAccess)) {
            // set the owning side to null (unless already changed)
            /**
             * if ($roomSessionAccess->getSession() === $this) {
                *$roomSessionAccess->setSession(null);
            *}
             */
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEndDateTime(): ?\DateTimeInterface
    {
        return $this->endDateTime;
    }

    public function setEndDateTime(\DateTimeInterface $endDateTime): self
    {
        $this->endDateTime = $endDateTime;

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
            $sessionMeeting->setSession($this);
        }

        return $this;
    }

    public function removeSessionMeeting(SessionMeetings $sessionMeeting): self
    {
        if ($this->sessionMeetings->removeElement($sessionMeeting)) {
            // set the owning side to null (unless already changed)
            if ($sessionMeeting->getSession() === $this) {
                $sessionMeeting->setSession(null);
            }
        }

        return $this;
    }
}
