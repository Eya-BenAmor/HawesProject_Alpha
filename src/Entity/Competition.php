<?php

namespace App\Entity;

use App\Repository\CompetitionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompetitionRepository::class)
 */
class Competition
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
      * @Assert\NotBlank(
     *      message = "champs ne doit pas etre vide")
     * )
     */
    private $Nom;

    /**
     * @ORM\Column(type="integer")
      * @Assert\NotBlank(
     *      message = "champs ne doit pas etre vide")
     * )
     */
    private $distance;

/**
     * @ORM\Column(type="date")
       * @Assert\GreaterThan("today", message="La date ne doit pas être inférieure à la date d'aujourd'hui")
     */
    private $date;

/**
     * @ORM\Column(type="integer")
      * @Assert\NotBlank(
     *      message = "champs ne doit pas etre vide")
     * )
     */
    private $prix;

    
    /**
   
     * @ORM\OneToMany(targetEntity=Cadeau::class, mappedBy="competition", cascade={"all"}, orphanRemoval=true)
     */
    private $id_cadeau;
    public function __toString()
{
    return $this->getNom();
}

    public function __construct()
    {
        $this->id_cadeau = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getDistance(): ?string
    {
        return $this->distance;
    }

    public function setDistance(string $distance): self
    {
        $this->distance = $distance;

        return $this;
    }



    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }


    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }



    /**
     * @return Collection|Cadeau[]
     */
    public function getIdCadeau(): Collection
    {
        return $this->id_cadeau;
    }

    public function addIdCadeau(Cadeau $idCadeau): self
    {
        if (!$this->id_cadeau->contains($idCadeau)) {
            $this->id_cadeau[] = $idCadeau;
            $idCadeau->setCompetition($this);
        }

        return $this;
    }

    public function removeIdCadeau(Cadeau $idCadeau): self
    {
        if ($this->id_cadeau->removeElement($idCadeau)) {
            // set the owning side to null (unless already changed)
            if ($idCadeau->getCompetition() === $this) {
                $idCadeau->setCompetition(null);
            }
        }

        return $this;
    }
   
}