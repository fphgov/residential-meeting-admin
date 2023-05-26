<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;

interface AuditLogServiceInterface
{
    public function log(
        User $user,
        string $action,
        ?string $code = null,
        ?string $extra = null
    ): void;
}
