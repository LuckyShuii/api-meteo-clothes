<?php

namespace App\Entity;

use App\Repository\ClotheTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClotheTypeRepository::class)]
class ClotheType
{
    public function __construct()
    {
        $this->clothes = new ArrayCollection();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $temperature = null;

    /**
     * @var Collection<int, Clothe>
     */
    #[ORM\OneToMany(targetEntity: Clothe::class, mappedBy: 'clothe_type')]
    private Collection $clothes;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTemperature(): ?string
    {
        return $this->temperature;
    }

    public function setTemperature(string $temperature): static
    {
        $this->temperature = $temperature;

        return $this;
    }

    /**
     * @return Collection<int, Clothe>
     */
    public function getClothes(): Collection
    {
        return $this->clothes;
    }

    public function addClothes(Clothe $clothes): static
    {
        if (!$this->clothes->contains($clothes)) {
            $this->clothes->add($clothes);
            $clothes->setClotheType($this);
        }

        return $this;
    }

    public function removeClothes(Clothe $clothes): static
    {
        if ($this->clothes->removeElement($clothes)) {
            // set the owning side to null (unless already changed)
            if ($clothes->getClotheType() === $this) {
                $clothes->setClotheType(null);
            }
        }

        return $this;
    }
}
