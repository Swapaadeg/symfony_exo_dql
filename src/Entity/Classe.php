<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $class_name = null;

    /**
     * @var Collection<int, Survivant>
     */
    #[ORM\ManyToMany(targetEntity: Survivant::class, mappedBy: 'classe')]
    private Collection $survivants;

    public function __construct()
    {
        $this->survivants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClassName(): ?string
    {
        return $this->class_name;
    }

    public function setClassName(string $class_name): static
    {
        $this->class_name = $class_name;

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
            $survivant->addClasse($this);
        }

        return $this;
    }

    public function removeSurvivant(Survivant $survivant): static
    {
        if ($this->survivants->removeElement($survivant)) {
            $survivant->removeClasse($this);
        }

        return $this;
    }
}
