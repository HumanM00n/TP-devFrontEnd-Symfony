<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 2)]
    private ?string $iso = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Postal>
     */
    #[ORM\OneToMany(targetEntity: Postal::class, mappedBy: 'country')]
    private Collection $postals;

    public function __construct()
    {
        $this->postals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIso(): ?string
    {
        return $this->iso;
    }

    public function setIso(string $iso): static
    {
        $this->iso = $iso;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Postal>
     */
    public function getPostals(): Collection
    {
        return $this->postals;
    }

    public function addPostal(Postal $postal): static
    {
        if (!$this->postals->contains($postal)) {
            $this->postals->add($postal);
            $postal->setCountry($this);
        }

        return $this;
    }

    public function removePostal(Postal $postal): static
    {
        if ($this->postals->removeElement($postal)) {
            // set the owning side to null (unless already changed)
            if ($postal->getCountry() === $this) {
                $postal->setCountry(null);
            }
        }

        return $this;
    }
}
