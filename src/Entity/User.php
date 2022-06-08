<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;


    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(min= 2 , max=50)
     */
    private ?string $fullName = null;

    /**
     * @return string|null
     */
    public function getFullName () : ?string
    {
        return $this -> fullName;
    }

    /**
     * @param string|null $fullName
     */
    public function setFullName ( ?string $fullName ) : void
    {
        $this -> fullName = $fullName;
    }


    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email()
     * @Assert\Length(min= 2 ,max= 180)
     */
    private ?string $email = null;

    /**
     * @ORM\Column(type="json")
     * @Assert\NotNull()
     */
    private array $roles = [];


    private ?string $plainPassword = 'password';
    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private string $password = 'password';

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
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
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
