<?php

namespace App\Entity;

use App\Repository\EventsLanguagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventsLanguagesRepository::class)
 */
class EventsLanguages
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Events::class, mappedBy="eventLng")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity=MeetingSessions::class, mappedBy="language")
     */
    private $meetingSessions;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->meetingSessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection|Events[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Events $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setEventLng($this);
        }

        return $this;
    }

    public function removeEvent(Events $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getEventLng() === $this) {
                $event->setEventLng(null);
            }
        }

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
            $meetingSession->setLanguage($this);
        }

        return $this;
    }

    public function removeMeetingSession(MeetingSessions $meetingSession): self
    {
        if ($this->meetingSessions->removeElement($meetingSession)) {
            // set the owning side to null (unless already changed)
            if ($meetingSession->getLanguage() === $this) {
                $meetingSession->setLanguage(null);
            }
        }

        return $this;
    } 
}
