<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuditLogRepository")
 * @ORM\Table(name="audit_logs")
 */
class AuditLog
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @ORM\Column(name="admin_id", type="integer")
     */
    private int $adminId;

    /**
     * @ORM\Column(name="action_name", type="string")
     */
    private string $actionName;

    /**
     * @ORM\Column(name="extra", type="string", nullable=true)
     */
    private ?string $extra = null;

    /**
     * @ORM\Column(name="code", type="string", nullable=true)
     */
    private ?string $code = null;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private DateTime $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getAdminId(): int
    {
        return $this->adminId;
    }

    public function setAdminId(int $adminId): void
    {
        $this->adminId = $adminId;
    }

    public function setActionName(string $actionName): void
    {
        $this->actionName = $actionName;
    }

    public function getActionName(): string
    {
        return $this->actionName;
    }

    public function setExtra(?string $extra = null): void
    {
        $this->extra = $extra;
    }

    public function getExtra(): string
    {
        return $this->extra;
    }

    public function setCode(?string $code = null): void
    {
        $this->code = $code;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
