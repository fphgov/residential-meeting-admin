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
     * @Groups({"list", "full_detail"})
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

    /**
     * @ORM\Column(name="public_space", type="text", nullable=true)
     *
     * @Groups({"list", "full_detail"})
     */
    private ?string $publicSpace;

    /**
     * @ORM\Column(name="nature", type="string", length=255, nullable=true)
     *
     * @Groups({"list", "full_detail"})
     */
    private ?string $nature;

    /**
     * @ORM\Column(name="house_number", type="string", length=255, nullable=true)
     *
     * @Groups({"list", "full_detail"})
     */
    private ?string $houseNumber;

    /**
     * @ORM\Column(name="building", type="string", length=255, nullable=true)
     *
     * @Groups({"list", "full_detail"})
     */
    private ?string $building;

    /**
     * @ORM\Column(name="stairway", type="string", length=255, nullable=true)
     *
     * @Groups({"list", "full_detail"})
     */
    private ?string $stairway;

    /**
     * @ORM\Column(name="floor", type="string", length=255, nullable=true)
     *
     * @Groups({"list", "full_detail"})
     */
    private ?string $floor;

    /**
     * @ORM\Column(name="door", type="string", length=255, nullable=true)
     *
     * @Groups({"list", "full_detail"})
     */
    private ?string $door;

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

    public function getPublicSpace(): ?string
    {
        return $this->publicSpace;
    }

    public function getNature(): ?string
    {
        return $this->nature;
    }

    public function getHouseNumber(): ?string
    {
        return $this->houseNumber;
    }

    public function getBuilding(): ?string
    {
        return $this->building;
    }

    public function getStairway(): ?string
    {
        return $this->stairway;
    }

    public function getFloor(): ?string
    {
        return $this->floor;
    }

    public function getDoor(): ?string
    {
        return $this->door;
    }
}
