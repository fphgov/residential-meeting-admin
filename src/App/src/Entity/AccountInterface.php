<?php

declare(strict_types=1);

namespace App\Entity;

use App\Interfaces\EntitySimpleInterface;

interface AccountInterface extends EntitySimpleInterface
{
    public function seAuthCode(string $authCode): void;

    public function geAuthCode(): string;

    public function getZipCode(): string;

    public function setZipCode(string $zipCode): void;

    public function getFullName(): string;

    public function setFullName(string $fullName): void;

    public function getAddress(): string;

    public function setAddress(string $address): void;

    public function getHouseNumber(): string;

    public function setHouseNumber(string $houseNumber): void;
}
