<?php

declare(strict_types=1);

namespace Jwt\Handler;

use App\Entity\User;
use App\Model\PBKDF2Password;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token as TokenInterface;
use Mezzio\Router\RouteResult;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function in_array;
use function strtolower;

class TokenHandler implements RequestHandlerInterface
{
    /** @var EntityManagerInterface */
    protected $em;

    /** @var array */
    private $config;

    public function __construct(EntityManagerInterface $em, array $config)
    {
        $this->em     = $em;
        $this->config = $config;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $postBody    = $request->getParsedBody();
        $routeResult = $request->getAttribute(RouteResult::class);

        $userRepository = $this->em->getRepository(User::class);

        if (! isset($postBody['email']) || ! isset($postBody['password'])) {
            return $this->badAuthentication();
        }

        $user = $userRepository->findOneBy(['email' => strtolower($postBody['email'])]);

        if (! $user) {
            return $this->badAuthentication();
        }

        if (! $user->getActive()) {
            return $this->badAuthentication();
        }

        if (
            $routeResult->getMatchedRouteName() === 'admin.api.login' &&
            in_array($user->getRole(), ['guest', 'user'], true)
        ) {
            return $this->badAuthentication();
        }

        $passwordModel = new PBKDF2Password($user->getPassword(), PBKDF2Password::PW_REPRESENTATION_STORABLE);

        if (! $passwordModel->verify($postBody['password'])) {
            return $this->badAuthentication();
        }

        $userData = [
            'username'  => $user->getUsername(),
            'firstname' => $user->getFirstname(),
            'lastname'  => $user->getLastname(),
            'email'     => $user->getEmail(),
            'role'      => $user->getRole(),
        ];

        $token = $this->generateToken($userData);

        return new JsonResponse([
            'token' => $token->toString(),
        ], 200);
    }

    private function badAuthentication(): JsonResponse
    {
        return new JsonResponse([
            'message' => 'Hibás bejelentkezési adatok vagy inaktív fiók',
        ], 400);
    }

    /** @var array claim */
    private function generateToken(array $claim = []): TokenInterface
    {
        $configuration = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText($this->config['auth']['secret'])
        );

        $time = new DateTimeImmutable();

        $usedAfter = $time->modify('+' . $this->config['nbf'] . ' minute');
        $expiresAt = $time->modify('+' . $this->config['exp'] . ' hour');

        return $configuration->builder()
                    ->issuedBy($this->config['iss']) // Configures the issuer (iss claim)
                    ->permittedFor($this->config['aud']) // Configures the issuer (iss claim)
                    ->identifiedBy($this->config['jti']) // Configures the audience (aud claim)
                    ->issuedAt($time) // Configures the time that the token was issued (iat claim)
                    ->canOnlyBeUsedAfter($usedAfter) // Configures the time that the token can be used (nbf claim)
                    ->expiresAt($expiresAt) // Configures the expiration time of the token (exp claim)
                    ->withClaim('user', $claim)
                    ->getToken($configuration->signer(), $configuration->signingKey());
    }
}
