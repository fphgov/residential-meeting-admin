<?php

declare(strict_types=1);

namespace App\Entity;

use App\Traits\EntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AccountRepository")
 * @ORM\Table(name="accounts", indexes={@ORM\Index(name="account_idx", columns={"auth_code"})})
 */
class Account implements AccountInterface
{
    use EntityTrait;

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups({"list", "option", "detail", "full_detail", "vote_list"})
     */
    protected int $id;

    /**
     * @ORM\Column(name="auth_code", type="string", length=14)
     *
     * @Groups({"full_detail"})
     */
    private string $authCode;

    /**
     * @ORM\Column(name="zip_code", type="string", length=4, nullable=false)
     *
     * @Groups({"list", "full_detail"})
     */
    private string $zipCode;

    /**
     * @ORM\Column(name="lastname", type="string", length=255, nullable=false)
     *
     * @Groups({"list", "full_detail"})
     */
    private string $lastname;

    /**
     * @ORM\Column(name="full_name", type="string", length=255, nullable=false)
     *
     * @Groups({"list", "full_detail"})
     */
    private string $fullName;

    /**
     * @ORM\Column(name="address", type="text", nullable=false)
     *
     * @Groups({"list", "full_detail"})
     */
    private string $address;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setAuthCode(string $authCode): void
    {
        $this->authCode = $authCode;
    }

    public function getAuthCode(): string
    {
        return $this->authCode;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }
}
