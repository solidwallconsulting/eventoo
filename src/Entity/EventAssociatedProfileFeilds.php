<?php

namespace App\Entity;

use App\Repository\EventAssociatedProfileFeildsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventAssociatedProfileFeildsRepository::class)
 */
class EventAssociatedProfileFeilds
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=EventProfiles::class, inversedBy="eventAssociatedProfileFeilds")
     */
    private $profile;

    /**
     * @ORM\ManyToOne(targetEntity=EventProfileFeilds::class, inversedBy="eventAssociatedProfileFeilds")
     */
    private $field;

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

    public function getField(): ?EventProfileFeilds
    {
        return $this->field;
    }

    public function setField(?EventProfileFeilds $field): self
    {
        $this->field = $field;

        return $this;
    }
}
