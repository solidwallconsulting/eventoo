<?php

namespace App\Entity;

use App\Repository\NotesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NotesRepository::class)
 */
class Notes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Clients::class, inversedBy="notes")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=NotesCategories::class, inversedBy="notes")
     */
    private $category;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isAdminNote;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getClient(): ?Clients
    {
        return $this->client;
    }

    public function setClient(?Clients $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getCategory(): ?NotesCategories
    {
        return $this->category;
    }

    public function setCategory(?NotesCategories $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getIsAdminNote(): ?bool
    {
        return $this->isAdminNote;
    }

    public function setIsAdminNote(?bool $isAdminNote): self
    {
        $this->isAdminNote = $isAdminNote;

        return $this;
    }
}
