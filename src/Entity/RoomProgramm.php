<?php

namespace App\Entity;

use App\Repository\RoomProgrammRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomProgrammRepository::class)
 */
class RoomProgramm
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=EventRooms::class, inversedBy="roomProgramms")
     */
    private $room;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $timezone;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $tags = [];

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $manageInteractivity;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $canChat;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $activateSondage;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $activateParticipantsList;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $activateQuestionResponse;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $sendQuestioninPrivate;

    /**
     * @ORM\Column(type="integer")
     */
    private $mode;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $liveLinkURL;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $liveTranslationLinkURL;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $reShareLinkURL;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $reShareTranslationLinkURL;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mainSponsorPhotoURL;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $canBeShowenInProgrammePage;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;
 

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $participants = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $sponsors = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $exposers = [];

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setTimezone(?string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(?array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getManageInteractivity(): ?bool
    {
        return $this->manageInteractivity;
    }

    public function setManageInteractivity(?bool $manageInteractivity): self
    {
        $this->manageInteractivity = $manageInteractivity;

        return $this;
    }

    public function getCanChat(): ?bool
    {
        return $this->canChat;
    }

    public function setCanChat(?bool $canChat): self
    {
        $this->canChat = $canChat;

        return $this;
    }

    public function getActivateSondage(): ?bool
    {
        return $this->activateSondage;
    }

    public function setActivateSondage(?bool $activateSondage): self
    {
        $this->activateSondage = $activateSondage;

        return $this;
    }

    public function getActivateParticipantsList(): ?bool
    {
        return $this->activateParticipantsList;
    }

    public function setActivateParticipantsList(?bool $activateParticipantsList): self
    {
        $this->activateParticipantsList = $activateParticipantsList;

        return $this;
    }

    public function getActivateQuestionResponse(): ?bool
    {
        return $this->activateQuestionResponse;
    }

    public function setActivateQuestionResponse(?bool $activateQuestionResponse): self
    {
        $this->activateQuestionResponse = $activateQuestionResponse;

        return $this;
    }

    public function getSendQuestioninPrivate(): ?bool
    {
        return $this->sendQuestioninPrivate;
    }

    public function setSendQuestioninPrivate(?bool $sendQuestioninPrivate): self
    {
        $this->sendQuestioninPrivate = $sendQuestioninPrivate;

        return $this;
    }

    public function getMode(): ?int
    {
        return $this->mode;
    }

    public function setMode(int $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    public function getLiveLinkURL(): ?string
    {
        return $this->liveLinkURL;
    }

    public function setLiveLinkURL(?string $liveLinkURL): self
    {
        $this->liveLinkURL = $liveLinkURL;

        return $this;
    }

    public function getLiveTranslationLinkURL(): ?string
    {
        return $this->liveTranslationLinkURL;
    }

    public function setLiveTranslationLinkURL(?string $liveTranslationLinkURL): self
    {
        $this->liveTranslationLinkURL = $liveTranslationLinkURL;

        return $this;
    }

    public function getReShareLinkURL(): ?string
    {
        return $this->reShareLinkURL;
    }

    public function setReShareLinkURL(?string $reShareLinkURL): self
    {
        $this->reShareLinkURL = $reShareLinkURL;

        return $this;
    }

    public function getReShareTranslationLinkURL(): ?string
    {
        return $this->reShareTranslationLinkURL;
    }

    public function setReShareTranslationLinkURL(?string $reShareTranslationLinkURL): self
    {
        $this->reShareTranslationLinkURL = $reShareTranslationLinkURL;

        return $this;
    }

    public function getMainSponsorPhotoURL(): ?string
    {
        return $this->mainSponsorPhotoURL;
    }

    public function setMainSponsorPhotoURL(?string $mainSponsorPhotoURL): self
    {
        $this->mainSponsorPhotoURL = $mainSponsorPhotoURL;

        return $this;
    }

    public function getCanBeShowenInProgrammePage(): ?bool
    {
        return $this->canBeShowenInProgrammePage;
    }

    public function setCanBeShowenInProgrammePage(?bool $canBeShowenInProgrammePage): self
    {
        $this->canBeShowenInProgrammePage = $canBeShowenInProgrammePage;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

 
 

    public function getParticipants(): ?array
    {
        return $this->participants;
    }

    public function setParticipants(?array $participants): self
    {
        $this->participants = $participants;

        return $this;
    }

    public function getSponsors(): ?array
    {
        return $this->sponsors;
    }

    public function setSponsors(?array $sponsors): self
    {
        $this->sponsors = $sponsors;

        return $this;
    }

    public function getExposers(): ?array
    {
        return $this->exposers;
    }

    public function setExposers(?array $exposers): self
    {
        $this->exposers = $exposers;

        return $this;
    }
}
