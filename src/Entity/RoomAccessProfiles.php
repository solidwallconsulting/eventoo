<?php

namespace App\Entity;

use App\Repository\RoomAccessProfilesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomAccessProfilesRepository::class)
 */
class RoomAccessProfiles
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=eventRooms::class, inversedBy="roomAccessProfiles")
     */
    private $room;

    /**
     * @ORM\ManyToOne(targetEntity=EventProfiles::class, inversedBy="roomAccessProfiles")
     */
    private $profile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoom(): ?eventRooms
    {
        return $this->room;
    }

    public function setRoom(?eventRooms $room): self
    {
        $this->room = $room;

        return $this;
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
}
