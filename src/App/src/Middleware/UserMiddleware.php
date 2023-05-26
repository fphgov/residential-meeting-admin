<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Jwt\Handler\JwtAuthMiddleware;
use Mezzio\Authentication\DefaultUser;
use Mezzio\Authentication\UserInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UserMiddleware implements MiddlewareInterface
{
    private UserRepository $userRepository;

    public function __construct(
        private EntityManagerInterface $em
    ) {
        $this->em             = $em;
        $this->userRepository = $this->em->getRepository(User::class);
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $token = $request->getAttribute(JwtAuthMiddleware::class);

        $user = $this->userRepository->findOneBy([
            'email' => $token['user']->email,
        ]);

        $ui = new DefaultUser($user->getEmail(), [$user->getRole()]);

        return $handler->handle(
            $request
                ->withAttribute(self::class, $user)
                ->withAttribute(UserInterface::class, $ui)
        );
    }
}
