<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Entity\UserInterface;
use App\Exception\UserNotFoundException;
use App\Model\PBKDF2Password;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Log\Logger;

final class UserService implements UserServiceInterface
{
    private UserRepository $userRepository;

    public function __construct(
        private EntityManagerInterface $em,
        private Logger $audit
    ) {
        $this->em             = $em;
        $this->audit          = $audit;
        $this->userRepository = $this->em->getRepository(User::class);
    }

    public function resetPassword(string $hash, string $password): void
    {
        $filteredParams = [
            'hash'     => $hash,
            'password' => $password,
        ]; // TODO: filter

        $user = $this->userRepository->findOneBy([
            'hash'   => $hash,
            'active' => true,
        ]);

        if (! $user instanceof UserInterface) {
            throw new UserNotFoundException($hash);
        }

        $password = new PBKDF2Password($filteredParams['password']);

        $user->setHash(null);
        $user->setPassword($password->getStorableRepresentation());
        $user->setUpdatedAt(new DateTime());

        $this->em->flush();
    }
}
