<?php

declare(strict_types=1);

namespace App\Entity;

use App\Traits\EntityActiveTrait;
use App\Traits\EntityMetaTrait;
use App\Traits\EntityTrait;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{
    use EntityActiveTrait;
    use EntityMetaTrait;
    use EntityTrait;

    /**
     * @ORM\Column(name="username", type="string")
     *
     * @Groups({"profile"})
     */
    private string $username;

    /**
     * @ORM\Column(name="firstname", type="string")
     *
     * @Groups({"list", "detail", "full_detail", "profile"})
     */
    private string $firstname;

    /**
     * @ORM\Column(name="lastname", type="string")
     *
     * @Groups({"list", "detail", "full_detail", "profile"})
     */
    private string $lastname;

    /**
     * @ORM\Column(name="email", type="string", length=100, unique=true)
     *
     * @Groups({"full_detail", "profile"})
     */
    private string $email;

    /**
     * @ORM\Column(name="password", type="text")
     *
     * @Ignore()
     */
    private string $password;

    /**
     * @ORM\Column(name="role", type="string")
     *
     * @Ignore()
     */
    private string $role = 'user';

    /** @ORM\Column(name="hash", type="string", unique=true, nullable=true) */
    private ?string $hash;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     *
     * @Ignore()
     */
    protected DateTime $createdAt;

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setHash(?string $hash = null): void
    {
        $this->hash = $hash;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function generateToken(): string
    {
        $uuid4 = Uuid::uuid4();

        return $uuid4->toString();
    }
}
