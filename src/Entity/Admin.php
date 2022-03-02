<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 */
class Admin implements UserInterface
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
     * @ORM\Column(type="bigint")
     * @Assert\NotBlank(message="CIN is required")
     * @Assert\Length(
     *      min = "8",
     *      max = "8",
     *      minMessage = "Votre CIN doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre CIN ne peut pas être plus long que {{ limit }} caractères"
     * )
     */    
    private $cin;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\EqualTo(propertyPath = "mdp",
     * message="Vous n'avez pas saisi le même mot de passe !" )
     */
    private $confirm_mdp;

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

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getConfirmMdp(): ?string
    {
        return $this->confirm_mdp;
    }

    public function setConfirmMdp(string $confirm_mdp): self
    {
        $this->confirm_mdp = $confirm_mdp;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
