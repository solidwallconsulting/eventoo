<?php

namespace App\Entity;

use App\Repository\StandProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StandProductRepository::class)
 */
class StandProduct
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $descreption;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photoURL;

    /**
     * @ORM\ManyToOne(targetEntity=EventStands::class, inversedBy="standProducts")
     */
    private $stand;

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

    public function getDescreption(): ?string
    {
        return $this->descreption;
    }

    public function setDescreption(?string $descreption): self
    {
        $this->descreption = $descreption;

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
