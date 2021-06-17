<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"choice:read"}},
 *  denormalizationContext={"groups"={"choice:write"}})
 * )
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 * @UniqueEntity("ordre")
 */
class Question
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
     * @ORM\Column(type="integer", unique=true)*
     * @Groups({"choice:read", "choice:write"})
     */
    private $ordre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"choice:read", "choice:write"})
     */
    private $type;

    /**
     * @Groups({"choice:read", "choice:write"})
     * @ORM\OneToMany(targetEntity=Choice::class, mappedBy="question", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $choice;

    public function __construct()
    {
        $this->choice = new ArrayCollection();
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

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Choice[]
     */
    public function getChoice(): Collection
    {
        return $this->choice;
    }

    public function addChoice(Choice $choice): self
    {
        if (!$this->choice->contains($choice)) {
            $this->choice[] = $choice;
            $choice->setQuestion($this);
        }

        return $this;
    }

    public function removeChoice(Choice $choice): self
    {
        if ($this->choice->removeElement($choice)) {
            // set the owning side to null (unless already changed)
            if ($choice->getQuestion() === $this) {
                $choice->setQuestion(null);
            }
        }

        return $this;
    }
}
