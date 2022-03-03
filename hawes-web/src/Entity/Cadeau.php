<?php

namespace App\Entity;

use App\Repository\CadeauRepository;
use Symfony\Component\Validator\Constraints as Assert;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CadeauRepository::class)
 */
class Cadeau
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     * * @Assert\Length(
     *      min = 2,
     *      max = 10,
     *      minMessage = "Your categorie must be at least {{ limit }} characters long",
     *      maxMessage = "Your categorie cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    
    private $categorie_cadeau;

    /**
     * @ORM\Column(type="string", length=255)
      * @Assert\NotBlank(
     *      message = "champs ne doit pas etre vide")
     * )
     */
    private $description_cadeau;

    /**
     * @ORM\Column(type="string", length=255)
      * @Assert\NotBlank(
     *      message = "champs ne doit pas etre vide")
     * )
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity=Competition::class, inversedBy="id_cadeau")
     * @ORM\JoinColumn(nullable=false)
     */
    private $competition;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorieCadeau(): ?string
    {
        return $this->categorie_cadeau;
    }

    public function setCategorieCadeau(string $categorie_cadeau): self
    {
        $this->categorie_cadeau = $categorie_cadeau;

        return $this;
    }

    public function getDescriptionCadeau(): ?string
    {
        return $this->description_cadeau;
    }

    public function setDescriptionCadeau(string $description_cadeau): self
    {
        $this->description_cadeau = $description_cadeau;

        return $this;
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

    public function getCompetition(): ?Competition
    {
        return $this->competition;
    }

    public function setCompetition(?Competition $competition): self
    {
        $this->competition = $competition;

        return $this;
    }
    
    
}
