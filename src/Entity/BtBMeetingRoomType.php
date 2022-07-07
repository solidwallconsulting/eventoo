<?php

namespace App\Entity;

use App\Repository\BtBMeetingRoomTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BtBMeetingRoomTypeRepository::class)
 */
class BtBMeetingRoomType
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
    private $meet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMeet(): ?string
    {
        return $this->meet;
    }

    public function setMeet(?string $meet): self
    {
        $this->meet = $meet;

        return $this;
    }
}
