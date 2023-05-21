<?php

declare(strict_types=1);

namespace App\Service;

interface AccountServiceInterface
{
    /** @var return \App\Entity\AccountInterface[] */
    public function getAccounts(
        string $zipCode,
        string $name,
        ?string $address,
    ): array;

    public function sendAccounts(string $id, string $email): void;
}
