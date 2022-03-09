<?php

namespace App\Entity;

use App\Repository\RandonneeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ORM\Entity(repositoryClass=RandonneeRepository::class)
 
 
 * @UniqueEntity("nomRando", message = "Le randonnée existe déjà")
 */

class Randonnee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
    
     * @Assert\NotBlank(
     *      message = "champs ne doit pas etre vide"
     * )
     * @Groups("post:read")
     */
    private $nomRando;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *      message = "champs ne doit pas etre vide")
     * @Groups("post:read")
     
     */
    private $destination;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "champs ne doit pas etre vide")
     * @Groups("post:read")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *      message = "champs ne doit pas etre vide")
     
     */
    private $categorieRando;

    /**
     * @ORM\Column(type="date")
     *    * @Assert\NotBlank(
     *      message = "champs ne doit pas etre vide")
     * )
    
    
  
     */
    private $dateRando;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *      message = "champs ne doit pas etre vide")
     * @Groups("post:read")
     */
    private $dureeRando;

    /**
     * @ORM\OneToMany(targetEntity=Participant::class, mappedBy="randonnee", orphanRemoval=true)
     */
    private $participant;

    /**
     * @ORM\Column(type="string", length=255)
    
     */
    private $image;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(
     *      message = "champs ne doit pas etre vide")
     *  @Assert\PositiveOrZero(
     *      message = "prix ne peut pas etre negative"
     * )
     */
    private $prix;

    /**
     * @ORM\Column(type="float")
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $couleur;

    public function __construct()
    {
        $this->participant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomRando(): ?string
    {
        return $this->nomRando;
    }

    public function setNomRando(string $nomRando): self
    {
        $this->nomRando = $nomRando;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategorieRando(): ?string
    {
        return $this->categorieRando;
    }

    public function setCategorieRando(string $categorieRando): self
    {
        $this->categorieRando = $categorieRando;

        return $this;
    }

    public function getDateRando(): ?\DateTimeInterface
    {
        return $this->dateRando;
    }

    public function setDateRando(\DateTimeInterface $dateRando): self
    {
        $this->dateRando = $dateRando;

        return $this;
    }

    public function getDureeRando(): ?string
    {
        return $this->dureeRando;
    }

    public function setDureeRando(string $dureeRando): self
    {
        $this->dureeRando = $dureeRando;

        return $this;
    }

    /**
     * @return Collection|Participant[]
     */
    public function getParticipant(): Collection
    {
        return $this->participant;
    }

    public function addParticipant(Participant $participant): self
    {
        if (!$this->participant->contains($participant)) {
            $this->participant[] = $participant;
            $participant->setRandonnee($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): self
    {
        if ($this->participant->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getRandonnee() === $this) {
                $participant->setRandonnee(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }
}
