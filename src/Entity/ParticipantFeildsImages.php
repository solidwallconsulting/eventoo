<?php

namespace App\Entity;

use App\Repository\ParticipantFeildsImagesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipantFeildsImagesRepository::class)
 */
class ParticipantFeildsImages
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
    private $labelFr;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $labelEN;



    /**
     * @ORM\ManyToOne(targetEntity=Participant::class, inversedBy="participantFeildsImages")
     */
    private $participant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $value;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabelFr(): ?string
    {
        return $this->labelFr;
    }

    public function setLabelFr(string $labelFr): self
    {
        $this->labelFr = $labelFr;

        return $this;
    }

    public function getLabelEN(): ?string
    {
        return $this->labelEN;
    }

    public function setLabelEN(string $labelEN): self
    {
        $this->labelEN = $labelEN;

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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
