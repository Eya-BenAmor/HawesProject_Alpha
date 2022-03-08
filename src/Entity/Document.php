<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DocumentRepository::class)
 */
class Document
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $typedoc;

    /**
     * @ORM\ManyToOne(targetEntity=Formation::class, inversedBy="documents")
     */
    private $id_formation;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombrepage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $liendoc;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypedoc(): ?string
    {
        return $this->typedoc;
    }

    public function setTypedoc(string $typedoc): self
    {
        $this->typedoc = $typedoc;

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

    public function getNombrepage(): ?int
    {
        return $this->nombrepage;
    }

    public function setNombrepage(string $nombrepage): self
    {
        $this->nombrepage = $nombrepage;

        return $this;
    }

    public function getLiendoc(): ?string
    {
        return $this->liendoc;
    }

    public function setLiendoc(string $liendoc): self
    {
        $this->liendoc = $liendoc;

        return $this;
    }
}
