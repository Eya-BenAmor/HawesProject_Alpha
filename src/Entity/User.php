<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Nom is required")
     * @Assert\Length(
     *      min = "5",
     *      minMessage = "Votre nom doit faire au moins {{ limit }} caractères",
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Prenom is required")
     * @Assert\Length(
     *      min = "5",
     *      minMessage = "Votre prenom doit faire au moins {{ limit }} caractères",
     * )
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Email is required")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Password is required")
     * @Assert\Length(
     *      min = "8",
     *      max = "32",
     *      minMessage = "Votre mdp doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre mdp ne peut pas être plus long que {{ limit }} caractères"
     * )
     */ 
    private $mdp;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\EqualTo(propertyPath = "mdp",
     * message="Vous n'avez pas saisi le même mot de passe !" )
     */
    private $confrim_mdp;

    protected $captchaCode;
    
    public function getCaptchaCode()
    {
      return $this->captchaCode;
    }

    public function setCaptchaCode($captchaCode)
    {
      $this->captchaCode = $captchaCode;
    }

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getConfrimMdp(): ?string
    {
        return $this->confrim_mdp;
    }

    public function setConfrimMdp(string $confrim_mdp): self
    {
        $this->confrim_mdp = $confrim_mdp;

        return $this;
    }
}
