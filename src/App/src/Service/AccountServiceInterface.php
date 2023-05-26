<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\UserInterface;
use Dompdf\Dompdf;

interface AccountServiceInterface
{
    /** @var return \App\Entity\AccountInterface[] */
    public function getAccounts(
        UserInterface $user,
        string $zipCode,
        string $name,
        ?string $address,
    ): array;

    public function sendAccount(
        UserInterface $user,
        string $id,
        string $email
    ): void;

    public function printAccount(
        UserInterface $user,
        string $id
    ): ?Dompdf;
}
