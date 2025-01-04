<?php

namespace App\Entity;

use App\Repository\RaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RaceRepository::class)]
class Race
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 10)]
    private ?string $type = null;

    /**
     * @var Collection<int, Animal>
     */
    #[ORM\OneToMany(targetEntity: Animal::class, mappedBy: 'race')]
    private Collection $animaux;

    public function __construct()
    {
        $this->animaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimaux(): Collection
    {
        return $this->animaux;
    }

    public function addAnimaux(Animal $animaux): static
    {
        if (!$this->animaux->contains($animaux)) {
            $this->animaux->add($animaux);
            $animaux->setRace($this);
        }

        return $this;
    }

    public function removeAnimaux(Animal $animal): static
    {
        if ($this->animaux->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getRace() === $this) {
                $animal->setRace(null);
            }
        }

        return $this;
    }
}
