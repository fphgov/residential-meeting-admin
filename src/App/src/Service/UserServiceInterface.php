<?php

declare(strict_types=1);

namespace App\Service;

interface UserServiceInterface
{
    public function resetPassword(string $hash, string $password): void;
}
