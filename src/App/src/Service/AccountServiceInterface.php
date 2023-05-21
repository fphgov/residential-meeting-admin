<?php

declare(strict_types=1);

namespace App\Service;

use Dompdf\Dompdf;

interface AccountServiceInterface
{
    /** @var return \App\Entity\AccountInterface[] */
    public function getAccounts(
        string $zipCode,
        string $name,
        ?string $address,
    ): array;

    public function sendAccounts(string $id, string $email): void;

    public function printAccounts(string $id): ?Dompdf;
}
