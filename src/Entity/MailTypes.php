<?php

namespace App\Entity;

use App\Repository\MailTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MailTypesRepository::class)
 */
class MailTypes
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
    private $label;

    /**
     * @ORM\OneToMany(targetEntity=MailTemplate::class, mappedBy="type")
     */
    private $mailTemplates;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $labelEN;

    public function __construct()
    {
        $this->mailTemplates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

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
            $mailTemplate->setType($this);
        }

        return $this;
    }

    public function removeMailTemplate(MailTemplate $mailTemplate): self
    {
        if ($this->mailTemplates->removeElement($mailTemplate)) {
            // set the owning side to null (unless already changed)
            if ($mailTemplate->getType() === $this) {
                $mailTemplate->setType(null);
            }
        }

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

 
      
}
