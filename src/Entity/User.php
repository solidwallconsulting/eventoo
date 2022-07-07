<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photoURL;

 

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\OneToOne(targetEntity=Clients::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $clients;


    /**
     * @ORM\OneToOne(targetEntity=Participant::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $participant;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sexe;

    /**
     * @ORM\OneToMany(targetEntity=AppointmentRequest::class, mappedBy="sender")
     */
    private $appointmentRequests;

 

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyEtablishment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $functionOccupation;

    /**
     * @ORM\OneToMany(targetEntity=Notifications::class, mappedBy="user")
     */
    private $notifications;

    /**
     * @ORM\ManyToOne(targetEntity=Countries::class, inversedBy="users")
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $activitySector;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $yourOffre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $yourNeeds;

    public function __construct()
    {
        $this->appointmentRequests = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPhotoURL(): ?string
    {
        return $this->photoURL;
    }

    public function setPhotoURL(string $photoURL): self
    {
        $this->photoURL = $photoURL;

        return $this;
    }
 

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getClients(): ?Clients
    {
        return $this->clients;
    }

    public function setClients(?Clients $clients): self
    {
        // unset the owning side of the relation if necessary
        if ($clients === null && $this->clients !== null) {
            $this->clients->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($clients !== null && $clients->getUser() !== $this) {
            $clients->setUser($this);
        }

        $this->clients = $clients;

        return $this;
    }


    public function getParticipant(): ?Participant
    {
        return $this->participant;
    }

    public function getSexe(): ?int
    {
        return $this->sexe;
    }

    public function setSexe(?int $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * @return Collection|AppointmentRequest[]
     */
    public function getAppointmentRequests(): Collection
    {
        return $this->appointmentRequests;
    }

    public function addAppointmentRequest(AppointmentRequest $appointmentRequest): self
    {
        if (!$this->appointmentRequests->contains($appointmentRequest)) {
            $this->appointmentRequests[] = $appointmentRequest;
            $appointmentRequest->setSender($this);
        }

        return $this;
    }

    public function removeAppointmentRequest(AppointmentRequest $appointmentRequest): self
    {
        if ($this->appointmentRequests->removeElement($appointmentRequest)) {
            // set the owning side to null (unless already changed)
            if ($appointmentRequest->getSender() === $this) {
                $appointmentRequest->setSender(null);
            }
        }

        return $this;
    }

 
 

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCompanyEtablishment(): ?string
    {
        return $this->companyEtablishment;
    }

    public function setCompanyEtablishment(?string $companyEtablishment): self
    {
        $this->companyEtablishment = $companyEtablishment;

        return $this;
    }

    public function getFunctionOccupation(): ?string
    {
        return $this->functionOccupation;
    }

    public function setFunctionOccupation(?string $functionOccupation): self
    {
        $this->functionOccupation = $functionOccupation;

        return $this;
    }

    /**
     * @return Collection|Notifications[]
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notifications $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setUser($this);
        }

        return $this;
    }

    public function removeNotification(Notifications $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getUser() === $this) {
                $notification->setUser(null);
            }
        }

        return $this;
    }

    public function getCountry(): ?Countries
    {
        return $this->country;
    }

    public function setCountry(?Countries $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getActivitySector(): ?string
    {
        return $this->activitySector;
    }

    public function setActivitySector(?string $activitySector): self
    {
        $this->activitySector = $activitySector;

        return $this;
    }

    public function getYourOffre(): ?string
    {
        return $this->yourOffre;
    }

    public function setYourOffre(?string $yourOffre): self
    {
        $this->yourOffre = $yourOffre;

        return $this;
    }

    public function getYourNeeds(): ?string
    {
        return $this->yourNeeds;
    }

    public function setYourNeeds(?string $yourNeeds): self
    {
        $this->yourNeeds = $yourNeeds;

        return $this;
    }

     

}
