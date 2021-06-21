<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"caract:read"}},
 *  denormalizationContext={"groups"={"caract:write"}},
 * )
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"caract:read", "caract:write"})
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=Caracteristique::class, mappedBy="client", cascade={"persist", "remove"})
     * @Groups({"caract:read", "caract:write"})
     */
    private $caracteristiques;

    public function __construct()
    {
        $this->datas = new ArrayCollection();
        $this->caracteristiques = new ArrayCollection();
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
            $caracteristique->setClient($this);
        }

        return $this;
    }

    public function removeCaracteristique(Caracteristique $caracteristique): self
    {
        if ($this->caracteristiques->removeElement($caracteristique)) {
            // set the owning side to null (unless already changed)
            if ($caracteristique->getClient() === $this) {
                $caracteristique->setClient(null);
            }
        }

        return $this;
    }
}
