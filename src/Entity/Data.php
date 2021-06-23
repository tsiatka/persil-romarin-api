<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DataRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=DataRepository::class)
 */
class Data
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"caract:read", "caract:write"})
     */
    private $nom_data;

    /**
     * @ORM\OneToMany(targetEntity=Caracteristique::class, mappedBy="data", cascade={"persist", "remove"},)
     */
    private $caracteristiques;

    /**
     * @ORM\OneToOne(targetEntity=Question::class, inversedBy="data", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $question;

    public function __construct()
    {
        $this->client_data = new ArrayCollection();
        $this->caracteristiques = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nom_data;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomData(): ?string
    {
        return $this->nom_data;
    }

    public function setNomData(string $nom_data): self
    {
        $this->nom_data = $nom_data;

        return $this;
    }

    /**
     * @return Collection|Caracteristique[]
     */
    public function getCaracteristiques(): Collection
    {
        return $this->caracteristiques;
    }

    public function addCaracteristique(Caracteristique $caracteristique): self
    {
        if (!$this->caracteristiques->contains($caracteristique)) {
            $this->caracteristiques[] = $caracteristique;
            $caracteristique->setData($this);
        }

        return $this;
    }

    public function removeCaracteristique(Caracteristique $caracteristique): self
    {
        if ($this->caracteristiques->removeElement($caracteristique)) {
            // set the owning side to null (unless already changed)
            if ($caracteristique->getData() === $this) {
                $caracteristique->setData(null);
            }
        }

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }
}
