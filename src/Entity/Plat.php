<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PlatRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=PlatRepository::class)
 * @Vich\Uploadable
 */
class Plat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $finishedAt;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $nomFichier;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $nomFichierOriginal;

    /**
     * @Vich\UploadableField(mapping="plat_image", fileNameProperty="nomFichier", originalName="nomFichierOriginal")
     */
    private $fichier;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $allergies;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $calories;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeInterface
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeInterface $startedAt): self
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getFinishedAt(): ?\DateTimeInterface
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(\DateTimeInterface $finishedAt): self
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    public function getNomFichierOriginal(): ?string
    {
        return $this->nomFichierOriginal;
    }

    public function setNomFichierOriginal(?string $nomFichierOriginal): self
    {
        $this->nomFichierOriginal = $nomFichierOriginal;

        return $this;
    }

    public function getNomFichier(): ?string
    {
        return $this->nomFichier;
    }

    public function setNomFichier(?string $nomFichier): self
    {
        $this->nomFichier = $nomFichier;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFichier()
    {
        return $this->fichier;
    }

    /**
     * @param mixed $fichier
     * @throws \Exception
     */
    public function setFichier(?File $fichier): void
    {
        $this->fichier = $fichier;
        if ($fichier) {
            $time = new \DateTime();
            $time->format('d-m-Y H:i:s');
            $this->dateDeCreation = $time;
            $this->dateDeModification = $time;
        }
    }

    public function getAllergies(): ?string
    {
        return $this->allergies;
    }

    public function setAllergies(?string $allergies): self
    {
        $this->allergies = $allergies;

        return $this;
    }

    public function getCalories(): ?float
    {
        return $this->calories;
    }

    public function setCalories(?float $calories): self
    {
        $this->calories = $calories;

        return $this;
    }
}
