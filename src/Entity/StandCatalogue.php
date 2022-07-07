<?php

namespace App\Entity;

use App\Repository\StandCatalogueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StandCatalogueRepository::class)
 */
class StandCatalogue
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
    private $catalogeName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $catalogePDFURL;

    /**
     * @ORM\ManyToOne(targetEntity=EventStands::class, inversedBy="standCatalogues")
     */
    private $stand;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCatalogeName(): ?string
    {
        return $this->catalogeName;
    }

    public function setCatalogeName(string $catalogeName): self
    {
        $this->catalogeName = $catalogeName;

        return $this;
    }

    public function getCatalogePDFURL(): ?string
    {
        return $this->catalogePDFURL;
    }

    public function setCatalogePDFURL(?string $catalogePDFURL): self
    {
        $this->catalogePDFURL = $catalogePDFURL;

        return $this;
    }

    public function getStand(): ?EventStands
    {
        return $this->stand;
    }

    public function setStand(?EventStands $stand): self
    {
        $this->stand = $stand;

        return $this;
    }
}
