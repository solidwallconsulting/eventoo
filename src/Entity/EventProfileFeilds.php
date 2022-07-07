<?php

namespace App\Entity;

use App\Repository\EventProfileFeildsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventProfileFeildsRepository::class)
 */
class EventProfileFeilds
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $labelFr;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $labelEN;

 

    /**
     * @ORM\ManyToOne(targetEntity=Events::class, inversedBy="eventProfileFeilds")
     */
    private $event;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $required;

    /**
     * @ORM\Column(type="integer")
     */
    private $lingneOrder;

    /**
     * @ORM\OneToMany(targetEntity=EventProfileFeildValue::class, mappedBy="eventFeild")
     */
    private $eventProfileFeildValues;

    /**
     * @ORM\OneToMany(targetEntity=EventAssociatedProfileFeilds::class, mappedBy="field")
     */
    private $eventAssociatedProfileFeilds;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $primaryFeild;

    public function __construct()
    {
        $this->eventProfileFeildValues = new ArrayCollection();
        $this->eventAssociatedProfileFeilds = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabelFr(): ?string
    {
        return $this->labelFr;
    }

    public function setLabelFr(?string $labelFr): self
    {
        $this->labelFr = $labelFr;

        return $this;
    }

    public function getLabelEN(): ?string
    {
        return $this->labelEN;
    }

    public function setLabelEN(?string $labelEN): self
    {
        $this->labelEN = $labelEN;

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

    public function getRequired(): ?bool
    {
        return $this->required;
    }

    public function setRequired(?bool $required): self
    {
        $this->required = $required;

        return $this;
    }

    public function getLingneOrder(): ?int
    {
        return $this->lingneOrder;
    }

    public function setLingneOrder(int $lingneOrder): self
    {
        $this->lingneOrder = $lingneOrder;

        return $this;
    }

    /**
     * @return Collection|EventProfileFeildValue[]
     */
    public function getEventProfileFeildValues(): Collection
    {
        return $this->eventProfileFeildValues;
    }

    public function addEventProfileFeildValue(EventProfileFeildValue $eventProfileFeildValue): self
    {
        if (!$this->eventProfileFeildValues->contains($eventProfileFeildValue)) {
            $this->eventProfileFeildValues[] = $eventProfileFeildValue;
            $eventProfileFeildValue->setEventFeild($this);
        }

        return $this;
    }

    public function removeEventProfileFeildValue(EventProfileFeildValue $eventProfileFeildValue): self
    {
        if ($this->eventProfileFeildValues->removeElement($eventProfileFeildValue)) {
            // set the owning side to null (unless already changed)
            if ($eventProfileFeildValue->getEventFeild() === $this) {
                $eventProfileFeildValue->setEventFeild(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EventAssociatedProfileFeilds[]
     */
    public function getEventAssociatedProfileFeilds(): Collection
    {
        return $this->eventAssociatedProfileFeilds;
    }

    public function addEventAssociatedProfileFeild(EventAssociatedProfileFeilds $eventAssociatedProfileFeild): self
    {
        if (!$this->eventAssociatedProfileFeilds->contains($eventAssociatedProfileFeild)) {
            $this->eventAssociatedProfileFeilds[] = $eventAssociatedProfileFeild;
            $eventAssociatedProfileFeild->setField($this);
        }

        return $this;
    }

    public function removeEventAssociatedProfileFeild(EventAssociatedProfileFeilds $eventAssociatedProfileFeild): self
    {
        if ($this->eventAssociatedProfileFeilds->removeElement($eventAssociatedProfileFeild)) {
            // set the owning side to null (unless already changed)
            if ($eventAssociatedProfileFeild->getField() === $this) {
                $eventAssociatedProfileFeild->setField(null);
            }
        }

        return $this;
    }

    public function getPrimaryFeild(): ?bool
    {
        return $this->primaryFeild;
    }

    public function setPrimaryFeild(?bool $primaryFeild): self
    {
        $this->primaryFeild = $primaryFeild;

        return $this;
    }

 
}
