<?php

declare(strict_types=1);

namespace App\Entity;

use App\Interfaces\EntityActiveInterface;
use App\Interfaces\EntityInterface;
use Doctrine\Common\Collections\Collection;

interface UserInterface extends EntityInterface, EntityActiveInterface
{
    public function setUsername(string $username): void;

    public function getUsername(): string;

    public function setFirstname(string $firstname): void;

    public function getFirstname(): string;

    public function setLastname(string $lastname): void;

    public function getLastname(): string;

    public function setEmail(string $email): void;

    public function getEmail(): string;

    public function setPassword(string $password): void;

    public function getPassword(): string;

    public function setRole(string $role): void;

    public function getRole(): ?string;

    public function setHash(?string $hash = null): void;

    public function getHash(): ?string;

    public function generateToken(): string;
}
