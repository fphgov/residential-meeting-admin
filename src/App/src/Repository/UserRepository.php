<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\UserInterface;
use App\Exception\UserNotFoundException;
use Doctrine\ORM\EntityRepository;

final class UserRepository extends EntityRepository
{
    public function getActiveUsers(): array
    {
        return $this->findBy([
            'active' => true,
            'role'   => 'user',
        ]);
    }

    public function getUserByHash(string $hash): UserInterface
    {
        $user = $this->findOneBy([
            'hash' => $hash,
        ]);

        if (! $user instanceof UserInterface) {
            throw new UserNotFoundException($hash);
        }

        return $user;
    }
}
