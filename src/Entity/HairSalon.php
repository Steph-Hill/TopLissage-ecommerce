<?php

namespace App\Entity;

use App\Repository\HairSalonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HairSalonRepository::class)]
class HairSalon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80)]
    private ?string $name = null;

    #[ORM\Column(length: 180)]
    private ?string $postalAdress = null;

    #[ORM\Column(length: 30)]
    private ?string $phone = null;

    #[ORM\Column(length: 5)]
    private ?string $employe = null;

    #[ORM\Column(length: 5)]
    private ?string $chair = null;

    #[ORM\ManyToOne]
    private ?Professional $professional_id = null;

    #[ORM\OneToMany(mappedBy: 'hairSalon', targetEntity: Administrator::class)]
    private Collection $administrators;

    public function __construct()
    {
        $this->administrators = new ArrayCollection();
    }

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

    public function getPostalAdress(): ?string
    {
        return $this->postalAdress;
    }

    public function setPostalAdress(string $postalAdress): self
    {
        $this->postalAdress = $postalAdress;

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

    public function getEmploye(): ?string
    {
        return $this->employe;
    }

    public function setEmploye(string $employe): self
    {
        $this->employe = $employe;

        return $this;
    }

    public function getChair(): ?string
    {
        return $this->chair;
    }

    public function setChair(string $chair): self
    {
        $this->chair = $chair;

        return $this;
    }

    public function getProfessionalId(): ?Professional
    {
        return $this->professional_id;
    }

    public function setProfessionalId(?Professional $professional_id): self
    {
        $this->professional_id = $professional_id;

        return $this;
    }

    /* Ajout de la fonction __tostring() */
    public function __toString(): string
    {
        // Convertis le champ le en sting
        return $this->postalAdress;
    }

    /**
     * @return Collection<int, Administrator>
     */
    public function getAdministrators(): Collection
    {
        return $this->administrators;
    }

    public function addAdministrator(Administrator $administrator): static
    {
        if (!$this->administrators->contains($administrator)) {
            $this->administrators->add($administrator);
            $administrator->setHairSalon($this);
        }

        return $this;
    }

    public function removeAdministrator(Administrator $administrator): static
    {
        if ($this->administrators->removeElement($administrator)) {
            // set the owning side to null (unless already changed)
            if ($administrator->getHairSalon() === $this) {
                $administrator->setHairSalon(null);
            }
        }

        return $this;
    }
}
