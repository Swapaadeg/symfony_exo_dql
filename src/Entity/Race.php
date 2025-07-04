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
    private ?string $race_name = null;

    /**
     * @var Collection<int, Survivant>
     */
    #[ORM\OneToMany(targetEntity: Survivant::class, mappedBy: 'race')]
    private Collection $survivants;

    public function __construct()
    {
        $this->survivants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRaceName(): ?string
    {
        return $this->race_name;
    }

    public function setRaceName(string $race_name): static
    {
        $this->race_name = $race_name;

        return $this;
    }

    /**
     * @return Collection<int, Survivant>
     */
    public function getSurvivants(): Collection
    {
        return $this->survivants;
    }

    public function addSurvivant(Survivant $survivant): static
    {
        if (!$this->survivants->contains($survivant)) {
            $this->survivants->add($survivant);
            $survivant->setRace($this);
        }

        return $this;
    }

    public function removeSurvivant(Survivant $survivant): static
    {
        if ($this->survivants->removeElement($survivant)) {
            // set the owning side to null (unless already changed)
            if ($survivant->getRace() === $this) {
                $survivant->setRace(null);
            }
        }

        return $this;
    }
}
