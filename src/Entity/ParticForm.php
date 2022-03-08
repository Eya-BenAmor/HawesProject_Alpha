<?php

namespace App\Entity;

use App\Repository\ParticFormRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ParticFormRepository::class)
 */
class ParticForm
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="nom de l'equipe est obligatoire")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="nom de l'equipe est obligatoire")
     */
    private $prenom;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $exp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $so_domaine;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $so_ass;

    /**
     * @ORM\ManyToOne(targetEntity=Formation::class)
     */
    private $id_formation;

    /**
     * @ORM\Column(type="integer")
     */
    private $Numero;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(string $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getExp(): ?string
    {
        return $this->exp;
    }

    public function setExp(string $exp): self
    {
        $this->exp = $exp;

        return $this;
    }

    public function getSoDomaine(): ?string
    {
        return $this->so_domaine;
    }

    public function setSoDomaine(string $so_domaine): self
    {
        $this->so_domaine = $so_domaine;

        return $this;
    }

    public function getSoAss(): ?string
    {
        return $this->so_ass;
    }

    public function setSoAss(string $so_ass): self
    {
        $this->so_ass = $so_ass;

        return $this;
    }

    public function getIdFormation(): ?Formation
    {
        return $this->id_formation;
    }

    public function setIdFormation(?Formation $id_formation): self
    {
        $this->id_formation = $id_formation;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->Numero;
    }

    public function setNumero(int $Numero): self
    {
        $this->Numero = $Numero;

        return $this;
    }
}
