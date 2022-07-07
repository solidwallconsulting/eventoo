<?php

namespace App\Entity;

use App\Repository\EventProfileFeildValueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventProfileFeildValueRepository::class)
 */
class EventProfileFeildValue
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
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=EventProfileFeilds::class, inversedBy="eventProfileFeildValues")
     */
    private $eventFeild;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $valueEN;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getEventFeild(): ?EventProfileFeilds
    {
        return $this->eventFeild;
    }

    public function setEventFeild(?EventProfileFeilds $eventFeild): self
    {
        $this->eventFeild = $eventFeild;

        return $this;
    }

    public function getValueEN(): ?string
    {
        return $this->valueEN;
    }

    public function setValueEN(string $valueEN): self
    {
        $this->valueEN = $valueEN;

        return $this;
    }
}
