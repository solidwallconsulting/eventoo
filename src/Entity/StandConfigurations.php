<?php

namespace App\Entity;

use App\Repository\StandConfigurationsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StandConfigurationsRepository::class)
 */
class StandConfigurations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=EventProfiles::class, cascade={"persist", "remove"})
     */
    private $profile;

    /**
     * @ORM\Column(type="integer")
     */
    private $maximumNumberOfProducts;

    /**
     * @ORM\Column(type="integer")
     */
    private $maximumNumberOfCatalogues;

    /**
     * @ORM\Column(type="integer")
     */
    private $maximumNumberOfVideos;

    /**
     * @ORM\ManyToOne(targetEntity=Events::class, inversedBy="standConfigurations")
     */
    private $event;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfile(): ?EventProfiles
    {
        return $this->profile;
    }

    public function setProfile(?EventProfiles $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    public function getMaximumNumberOfProducts(): ?int
    {
        return $this->maximumNumberOfProducts;
    }

    public function setMaximumNumberOfProducts(int $maximumNumberOfProducts): self
    {
        $this->maximumNumberOfProducts = $maximumNumberOfProducts;

        return $this;
    }

    public function getMaximumNumberOfCatalogues(): ?int
    {
        return $this->maximumNumberOfCatalogues;
    }

    public function setMaximumNumberOfCatalogues(int $maximumNumberOfCatalogues): self
    {
        $this->maximumNumberOfCatalogues = $maximumNumberOfCatalogues;

        return $this;
    }

    public function getMaximumNumberOfVideos(): ?int
    {
        return $this->maximumNumberOfVideos;
    }

    public function setMaximumNumberOfVideos(int $maximumNumberOfVideos): self
    {
        $this->maximumNumberOfVideos = $maximumNumberOfVideos;

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
