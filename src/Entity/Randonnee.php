<?php

namespace App\Entity;

use App\Repository\RandonneeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RandonneeRepository::class)
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
     */
    private $nomRando;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *      message = "champs ne doit pas etre vide")
     */
    private $destination;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "champs ne doit pas etre vide")
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
    
    * @Assert\GreaterThan("today", message="La date ne doit pas être inférieure à la date d'aujourd'hui")
  
     */
    private $dateRando;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *      message = "champs ne doit pas etre vide")
     */
    private $dureeRando;

    /**
     * @ORM\OneToMany(targetEntity=Participant::class, mappedBy="randonnee", orphanRemoval=true)
     */
    private $participant;

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
}
