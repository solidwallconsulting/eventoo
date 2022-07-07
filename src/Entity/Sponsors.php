<?php

namespace App\Entity;

use App\Repository\SponsorsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SponsorsRepository::class)
 */
class Sponsors
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
     * @ORM\ManyToOne(targetEntity=SponsorsTypes::class, inversedBy="sponsors")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logoURL;

    /**
     * @ORM\ManyToOne(targetEntity=Events::class, inversedBy="sponsors")
     */
    private $event;

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

    public function getType(): ?SponsorsTypes
    {
        return $this->type;
    }

    public function setType(?SponsorsTypes $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getLogoURL(): ?string
    {
        return $this->logoURL;
    }

    public function setLogoURL(string $logoURL): self
    {
        $this->logoURL = $logoURL;

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
}
