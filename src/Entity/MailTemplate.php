<?php

namespace App\Entity;

use App\Repository\MailTemplateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MailTemplateRepository::class)
 */
class MailTemplate
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
    private $object;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $profiles = [];

    /**
     * @ORM\ManyToOne(targetEntity=Events::class, inversedBy="mailTemplates")
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity=MailTypes::class, inversedBy="mailTemplates")
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(string $object): self
    {
        $this->object = $object;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

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

    public function getProfiles(): ?array
    {
        return $this->profiles;
    }

    public function setProfiles(?array $profiles): self
    {
        $this->profiles = $profiles;

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

    public function getType(): ?MailTypes
    {
        return $this->type;
    }

    public function setType(?MailTypes $type): self
    {
        $this->type = $type;

        return $this;
    }
}
