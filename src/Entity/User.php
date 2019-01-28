<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *  * @UniqueEntity(
 *     fields = {"email"},
 *     message = "Le mail que vous avez indiquer est déjâ utilise"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     ** @Assert\Length(min=8, minMessage = "Votre mot de passe doit faire au minimum 8 caractéres")
     */
    private $password;
    /**
     * @Assert\EqualTo(propertyPath="password",message ="Les deux mot de passe sont different")
     */
    private $confirm_password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $borrowerNote;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $lenderNote;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $tokens;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Objet", mappedBy="user")
     */
    private $objets;

    public function __construct()
    {
        $this->objets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getConfirmPassword()
    {
        return $this->confirm_password;
    }

    public function setConfirmPassword($confirm_password): void
    {
        $this->confirm_password = $confirm_password;
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

    public function getBorrowerNote(): ?int
    {
        return $this->borrowerNote;
    }

    public function setBorrowerNote(?int $borrowerNote): self
    {
        $this->borrowerNote = $borrowerNote;

        return $this;
    }

    public function getLenderNote(): ?int
    {
        return $this->lenderNote;
    }

    public function setLenderNote(?int $lenderNote): self
    {
        $this->lenderNote = $lenderNote;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTokens(): ?int
    {
        return $this->tokens;
    }

    public function setTokens(int $tokens): self
    {
        $this->tokens = $tokens;

        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return array('ROLE_USER');
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles(): array
    {
        return array_unique(array_merge(['ROLE_USER'], $this->roles));
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    public function resetRoles()
    {
        $this->roles = [];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Collection|Objet[]
     */
    public function getObjets(): Collection
    {
        return $this->objets;
    }

    public function addObjet(Objet $objet): self
    {
        if (!$this->objets->contains($objet)) {
            $this->objets[] = $objet;
            $objet->setUser($this);
        }

        return $this;
    }

    public function removeObjet(Objet $objet): self
    {
        if ($this->objets->contains($objet)) {
            $this->objets->removeElement($objet);
            // set the owning side to null (unless already changed)
            if ($objet->getUser() === $this) {
                $objet->setUser(null);
            }
        }

        return $this;
    }
}
