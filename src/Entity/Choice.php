<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChoiceRepository;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ChoiceRepository::class)
 * @Vich\Uploadable
 */
class Choice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"choice:read", "choice:write"})
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"choice:read", "choice:write"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDeCreation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDeModification;
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     * @Groups({"choice:read", "choice:write"})
     */
    private $nomFichier;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $nomFichierOriginal;

    /**
     * @Vich\UploadableField(mapping="choice_image", fileNameProperty="nomFichier", originalName="nomFichierOriginal")
     * @Groups({"choice:read", "choice:write"})
     */
    private $fichier;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="choice")
     */
    private $question;

    public function __construct()
    {
        $this->setDateDeModification(new \DateTime());
        $this->setDateDeCreation(new \DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
    public function getDateDeCreation(): ?\DateTimeInterface
    {
        return $this->dateDeCreation;
    }

    public function setDateDeCreation(?\DateTimeInterface $dateDeCreation): self
    {
        $this->dateDeCreation = $dateDeCreation;

        return $this;
    }

    public function getDateDeModification(): ?\DateTimeInterface
    {
        return $this->dateDeModification;
    }

    public function setDateDeModification(?\DateTimeInterface $dateDeModification): self
    {
        $this->dateDeModification = $dateDeModification;

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
