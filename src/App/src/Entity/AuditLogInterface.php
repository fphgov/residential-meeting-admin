<?php

declare(strict_types=1);

namespace App\Entity;

use App\Interfaces\EntitySimpleInterface;
use DateTime;

interface AuditLogInterface extends EntitySimpleInterface
{
    public function getId(): int;

    public function setId(int $id): void;

    public function setCode(?string $code = null): void;

    public function getCode(): ?string;

    public function setActionName(string $name): void;

    public function getActionName(): string;

    public function setExtra(?string $extra = null): void;

    public function getExtra(): ?string;

    public function getCreatedAt(): DateTime;

    public function setCreatedAt(DateTime $createdAt): void;
}
