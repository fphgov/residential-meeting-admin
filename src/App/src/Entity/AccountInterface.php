<?php

declare(strict_types=1);

namespace App\Entity;

use App\Interfaces\EntitySimpleInterface;

interface AccountInterface extends EntitySimpleInterface
{
    public function setAuthCode(string $authCode): void;

    public function getAuthCode(): string;

    public function getZipCode(): string;

    public function setZipCode(string $zipCode): void;

    public function getFullName(): string;

    public function setFullName(string $fullName): void;

    public function getAddress(): string;

    public function setAddress(string $address): void;

    public function getLastname(): string;

    public function setLastname(string $houseNumber): void;
}
