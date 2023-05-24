<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Entity\AuditLog;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

final class AuditLogService implements AuditLogServiceInterface
{
    public function __construct(
        private array $config,
        private EntityManagerInterface $em
    ) {
        $this->config = $config;
        $this->em     = $em;
    }

    public function log(
        User $user,
        string $action,
        ?string $code = null,
        ?string $extra = null
    ): void {
        $date = new DateTime();

        $auditLog = new AuditLog();
        $auditLog->setAdminId($user->getId());
        $auditLog->setActionName($action);
        $auditLog->setCode($code);
        $auditLog->setExtra($extra);
        $auditLog->setCreatedAt($date);

        $this->em->persist($auditLog);
        $this->em->flush();
    }
}
