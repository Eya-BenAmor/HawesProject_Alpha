<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $nomeq;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     * @Assert\NotBlank(message="nom de l'equipe est obligatoire")
     */
    private $domaine;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *      min = 1,
     *      max = 20,
     *      notInRangeMessage = "Duree doit etre entre 1 et 20 jours",
     * )
     */
    private $duree;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="id_formation")
     */
    private $documents;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     * @Assert\NotBlank(message="nom de formation est obligatoire")
     */
    private $nomform;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="nom de formation est obligatoire  ")
     */
    private $plan;

    /**
     * @Assert\NotBlank(message="champ date est obligatoire")
     * @Assert\Date
     * @var string A "Y-m-d" formatted value
     * @ORM\Column(type="string", length=255)
     */
    private $date;
 
    public function __toString()
{
    return $this->getnomeq();
}

    public function __construct()
    {
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomeq(): ?string
    {
        return $this->nomeq;
    }

    public function setNomeq(?string $nomeq): self
    {
        $this->nomeq = $nomeq;

        return $this;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(?string $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setIdFormation($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getIdFormation() === $this) {
                $document->setIdFormation(null);
            }
        }

        return $this;
    }

    public function getNomform(): ?string
    {
        return $this->nomform;
    }

    public function setNomform(?string $nomform): self
    {
        $this->nomform = $nomform;

        return $this;
    }

    public function getPlan(): ?string
    {
        return $this->plan;
    }

    public function setPlan(?string $plan): self
    {
        $this->plan = $plan;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }
}
