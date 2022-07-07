<?php

namespace App\Entity;

use App\Repository\EventsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventsRepository::class)
 */
class Events
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
     * @ORM\Column(type="integer")
     */
    private $totalSubscribersNumber;

    /**
     * @ORM\Column(type="integer")
     */
    private $eventsLengthInDays;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeZone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

 
 
 

    /**
     * @ORM\ManyToOne(targetEntity=Clients::class, inversedBy="events")
     */
    private $client;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photoURL;

 



    /**
     * @ORM\Column(type="string", length=2000, nullable=true)
     */
    private $steamingLINK;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $streamingPlatform;

    /**
     * @ORM\OneToMany(targetEntity=Sponsors::class, mappedBy="event")
     */
    private $sponsors;

    /**
     * @ORM\OneToMany(targetEntity=Exposer::class, mappedBy="event")
     */
    private $exposers;

    /**
     * @ORM\ManyToOne(targetEntity=EventTypes::class, inversedBy="events")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=EventsAccessTypes::class, inversedBy="events")
     */
    private $accessType;

    /**
     * @ORM\ManyToOne(targetEntity=EventsAccessibility::class, inversedBy="events")
     */
    private $eventAccessibility;

    /**
     * @ORM\ManyToOne(targetEntity=EventsDurations::class, inversedBy="events")
     */
    private $willBeAvailableForNMonths;

    /**
     * @ORM\ManyToOne(targetEntity=EventsLanguages::class, inversedBy="events")
     */
    private $eventLng;

    /**
     * @ORM\OneToMany(targetEntity=EventProfileFeilds::class, mappedBy="event")
     */
    private $eventProfileFeilds;

    /**
     * @ORM\OneToMany(targetEntity=EventProfiles::class, mappedBy="event")
     */
    private $eventProfiles;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $intoTheEventPhotoURL;

    /**
     * @ORM\OneToMany(targetEntity=MailTemplate::class, mappedBy="event")
     */
    private $mailTemplates;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logoURL;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logoAlt;

    /**
     * @ORM\OneToMany(targetEntity=EventRooms::class, mappedBy="event")
     */
    private $eventRooms;

    /**
     * @ORM\OneToMany(targetEntity=StandConfigurations::class, mappedBy="event")
     */
    private $standConfigurations;

    /**
     * @ORM\OneToMany(targetEntity=EventStands::class, mappedBy="event")
     */
    private $eventStands;

    /**
     * @ORM\OneToMany(targetEntity=BtBMeetingRoom::class, mappedBy="event")
     */
    private $btBMeetingRooms;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $themeColor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $textThemeColor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tabColor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tabFontColor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $agendaMenuColor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ExpoTabColor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numberOfSessionColor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $chatLinkColor;

 

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numberOfSessionTextColor;

    /**
     * @ORM\OneToMany(targetEntity=AppointmentRequest::class, mappedBy="event")
     */
    private $appointmentRequests;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $unqueID;

 

    public function __construct()
    {
        $this->sponsors = new ArrayCollection();
        $this->exposers = new ArrayCollection();
        $this->eventProfileFeilds = new ArrayCollection();
        $this->eventProfiles = new ArrayCollection();
        $this->mailTemplates = new ArrayCollection();
        $this->eventRooms = new ArrayCollection();
        $this->standConfigurations = new ArrayCollection();
        $this->eventStands = new ArrayCollection();
        $this->btBMeetingRooms = new ArrayCollection();
        $this->appointmentRequests = new ArrayCollection();
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


 

    public function getTotalSubscribersNumber(): ?int
    {
        return $this->totalSubscribersNumber;
    }

    public function setTotalSubscribersNumber(int $totalSubscribersNumber): self
    {
        $this->totalSubscribersNumber = $totalSubscribersNumber;

        return $this;
    }

    public function getEventsLengthInDays(): ?int
    {
        return $this->eventsLengthInDays;
    }

    public function setEventsLengthInDays(int $eventsLengthInDays): self
    {
        $this->eventsLengthInDays = $eventsLengthInDays;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getTypeZone(): ?string
    {
        return $this->typeZone;
    }

    public function setTypeZone(?string $typeZone): self
    {
        $this->typeZone = $typeZone;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

 
 

 

    public function getClient(): ?Clients
    {
        return $this->client;
    }

    public function setClient(?Clients $client): self
    {
        $this->client = $client;

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

 

 

    public function getSteamingLINK(): ?string
    {
        return $this->steamingLINK;
    }

    public function setSteamingLINK(?string $steamingLINK): self
    {
        $this->steamingLINK = $steamingLINK;

        return $this;
    }

    public function getStreamingPlatform(): ?string
    {
        return $this->streamingPlatform;
    }

    public function setStreamingPlatform(?string $streamingPlatform): self
    {
        $this->streamingPlatform = $streamingPlatform;

        return $this;
    }

    /**
     * @return Collection|Sponsors[]
     */
    public function getSponsors(): Collection
    {
        return $this->sponsors;
    }

    public function addSponsor(Sponsors $sponsor): self
    {
        if (!$this->sponsors->contains($sponsor)) {
            $this->sponsors[] = $sponsor;
            $sponsor->setEvent($this);
        }

        return $this;
    }

    public function removeSponsor(Sponsors $sponsor): self
    {
        if ($this->sponsors->removeElement($sponsor)) {
            // set the owning side to null (unless already changed)
            if ($sponsor->getEvent() === $this) {
                $sponsor->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Exposer[]
     */
    public function getExposers(): Collection
    {
        return $this->exposers;
    }

    public function addExposer(Exposer $exposer): self
    {
        if (!$this->exposers->contains($exposer)) {
            $this->exposers[] = $exposer;
            $exposer->setEvent($this);
        }

        return $this;
    }

    public function removeExposer(Exposer $exposer): self
    {
        if ($this->exposers->removeElement($exposer)) {
            // set the owning side to null (unless already changed)
            if ($exposer->getEvent() === $this) {
                $exposer->setEvent(null);
            }
        }

        return $this;
    }

    public function getType(): ?EventTypes
    {
        return $this->type;
    }

    public function setType(?EventTypes $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAccessType(): ?EventsAccessTypes
    {
        return $this->accessType;
    }

    public function setAccessType(?EventsAccessTypes $accessType): self
    {
        $this->accessType = $accessType;

        return $this;
    }

    public function getEventAccessibility(): ?EventsAccessibility
    {
        return $this->eventAccessibility;
    }

    public function setEventAccessibility(?EventsAccessibility $eventAccessibility): self
    {
        $this->eventAccessibility = $eventAccessibility;

        return $this;
    }

    public function getWillBeAvailableForNMonths(): ?EventsDurations
    {
        return $this->willBeAvailableForNMonths;
    }

    public function setWillBeAvailableForNMonths(?EventsDurations $willBeAvailableForNMonths): self
    {
        $this->willBeAvailableForNMonths = $willBeAvailableForNMonths;

        return $this;
    }

    public function getEventLng(): ?EventsLanguages
    {
        return $this->eventLng;
    }

    public function setEventLng(?EventsLanguages $eventLng): self
    {
        $this->eventLng = $eventLng;

        return $this;
    }

    /**
     * @return Collection|EventProfileFeilds[]
     */
    public function getEventProfileFeilds(): Collection
    {
        return $this->eventProfileFeilds;
    }

    public function addEventProfileFeild(EventProfileFeilds $eventProfileFeild): self
    {
        if (!$this->eventProfileFeilds->contains($eventProfileFeild)) {
            $this->eventProfileFeilds[] = $eventProfileFeild;
            $eventProfileFeild->setEvent($this);
        }

        return $this;
    }

    public function removeEventProfileFeild(EventProfileFeilds $eventProfileFeild): self
    {
        if ($this->eventProfileFeilds->removeElement($eventProfileFeild)) {
            // set the owning side to null (unless already changed)
            if ($eventProfileFeild->getEvent() === $this) {
                $eventProfileFeild->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EventProfiles[]
     */
    public function getEventProfiles(): Collection
    {
        return $this->eventProfiles;
    }

    public function addEventProfile(EventProfiles $eventProfile): self
    {
        if (!$this->eventProfiles->contains($eventProfile)) {
            $this->eventProfiles[] = $eventProfile;
            $eventProfile->setEvent($this);
        }

        return $this;
    }

    public function removeEventProfile(EventProfiles $eventProfile): self
    {
        if ($this->eventProfiles->removeElement($eventProfile)) {
            // set the owning side to null (unless already changed)
            if ($eventProfile->getEvent() === $this) {
                $eventProfile->setEvent(null);
            }
        }

        return $this;
    }

    public function getIntoTheEventPhotoURL(): ?string
    {
        return $this->intoTheEventPhotoURL;
    }

    public function setIntoTheEventPhotoURL(?string $intoTheEventPhotoURL): self
    {
        $this->intoTheEventPhotoURL = $intoTheEventPhotoURL;

        return $this;
    }

    /**
     * @return Collection|MailTemplate[]
     */
    public function getMailTemplates(): Collection
    {
        return $this->mailTemplates;
    }

    public function addMailTemplate(MailTemplate $mailTemplate): self
    {
        if (!$this->mailTemplates->contains($mailTemplate)) {
            $this->mailTemplates[] = $mailTemplate;
            $mailTemplate->setEvent($this);
        }

        return $this;
    }

    public function removeMailTemplate(MailTemplate $mailTemplate): self
    {
        if ($this->mailTemplates->removeElement($mailTemplate)) {
            // set the owning side to null (unless already changed)
            if ($mailTemplate->getEvent() === $this) {
                $mailTemplate->setEvent(null);
            }
        }

        return $this;
    }

    public function getLogoURL(): ?string
    {
        return $this->logoURL;
    }

    public function setLogoURL(?string $logoURL): self
    {
        $this->logoURL = $logoURL;

        return $this;
    }

    public function getLogoAlt(): ?string
    {
        return $this->logoAlt;
    }

    public function setLogoAlt(?string $logoAlt): self
    {
        $this->logoAlt = $logoAlt;

        return $this;
    }

    /**
     * @return Collection|EventRooms[]
     */
    public function getEventRooms(): Collection
    {
        return $this->eventRooms;
    }

    public function addEventRoom(EventRooms $eventRoom): self
    {
        if (!$this->eventRooms->contains($eventRoom)) {
            $this->eventRooms[] = $eventRoom;
            $eventRoom->setEvent($this);
        }

        return $this;
    }

    public function removeEventRoom(EventRooms $eventRoom): self
    {
        if ($this->eventRooms->removeElement($eventRoom)) {
            // set the owning side to null (unless already changed)
            if ($eventRoom->getEvent() === $this) {
                $eventRoom->setEvent(null);
            }
        }

        return $this;
    }



 
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection|StandConfigurations[]
     */
    public function getStandConfigurations(): Collection
    {
        return $this->standConfigurations;
    }

    public function addStandConfiguration(StandConfigurations $standConfiguration): self
    {
        if (!$this->standConfigurations->contains($standConfiguration)) {
            $this->standConfigurations[] = $standConfiguration;
            $standConfiguration->setEvent($this);
        }

        return $this;
    }

    public function removeStandConfiguration(StandConfigurations $standConfiguration): self
    {
        if ($this->standConfigurations->removeElement($standConfiguration)) {
            // set the owning side to null (unless already changed)
            if ($standConfiguration->getEvent() === $this) {
                $standConfiguration->setEvent(null);
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
            $eventStand->setEvent($this);
        }

        return $this;
    }

    public function removeEventStand(EventStands $eventStand): self
    {
        if ($this->eventStands->removeElement($eventStand)) {
            // set the owning side to null (unless already changed)
            if ($eventStand->getEvent() === $this) {
                $eventStand->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BtBMeetingRoom[]
     */
    public function getBtBMeetingRooms(): Collection
    {
        return $this->btBMeetingRooms;
    }

    public function addBtBMeetingRoom(BtBMeetingRoom $btBMeetingRoom): self
    {
        if (!$this->btBMeetingRooms->contains($btBMeetingRoom)) {
            $this->btBMeetingRooms[] = $btBMeetingRoom;
            $btBMeetingRoom->setEvent($this);
        }

        return $this;
    }

    public function removeBtBMeetingRoom(BtBMeetingRoom $btBMeetingRoom): self
    {
        if ($this->btBMeetingRooms->removeElement($btBMeetingRoom)) {
            // set the owning side to null (unless already changed)
            if ($btBMeetingRoom->getEvent() === $this) {
                $btBMeetingRoom->setEvent(null);
            }
        }

        return $this;
    }

    public function getThemeColor(): ?string
    {
        return $this->themeColor;
    }

    public function setThemeColor(?string $themeColor): self
    {
        $this->themeColor = $themeColor;

        return $this;
    }

    public function getTextThemeColor(): ?string
    {
        return $this->textThemeColor;
    }

    public function setTextThemeColor(?string $textThemeColor): self
    {
        $this->textThemeColor = $textThemeColor;

        return $this;
    }

    public function getTabColor(): ?string
    {
        return $this->tabColor;
    }

    public function setTabColor(?string $tabColor): self
    {
        $this->tabColor = $tabColor;

        return $this;
    }

    public function getTabFontColor(): ?string
    {
        return $this->tabFontColor;
    }

    public function setTabFontColor(?string $tabFontColor): self
    {
        $this->tabFontColor = $tabFontColor;

        return $this;
    }

    public function getAgendaMenuColor(): ?string
    {
        return $this->agendaMenuColor;
    }

    public function setAgendaMenuColor(?string $agendaMenuColor): self
    {
        $this->agendaMenuColor = $agendaMenuColor;

        return $this;
    }

    public function getExpoTabColor(): ?string
    {
        return $this->ExpoTabColor;
    }

    public function setExpoTabColor(?string $ExpoTabColor): self
    {
        $this->ExpoTabColor = $ExpoTabColor;

        return $this;
    }

    public function getNumberOfSessionColor(): ?string
    {
        return $this->numberOfSessionColor;
    }

    public function setNumberOfSessionColor(?string $numberOfSessionColor): self
    {
        $this->numberOfSessionColor = $numberOfSessionColor;

        return $this;
    }

    public function getChatLinkColor(): ?string
    {
        return $this->chatLinkColor;
    }

    public function setChatLinkColor(?string $chatLinkColor): self
    {
        $this->chatLinkColor = $chatLinkColor;

        return $this;
    }

    public function getNumberOfSessionTextColor(): ?string
    {
        return $this->numberOfSessionTextColor;
    }

    public function setNumberOfSessionTextColor(?string $numberOfSessionTextColor): self
    {
        $this->numberOfSessionTextColor = $numberOfSessionTextColor;

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
            $appointmentRequest->setEvent($this);
        }

        return $this;
    }

    public function removeAppointmentRequest(AppointmentRequest $appointmentRequest): self
    {
        if ($this->appointmentRequests->removeElement($appointmentRequest)) {
            // set the owning side to null (unless already changed)
            if ($appointmentRequest->getEvent() === $this) {
                $appointmentRequest->setEvent(null);
            }
        }

        return $this;
    }

    public function getUnqueID(): ?string
    {
        return $this->unqueID;
    }

    public function setUnqueID(string $unqueID): self
    {
        $this->unqueID = $unqueID;

        return $this;
    }

 
}
