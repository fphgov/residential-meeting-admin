<?php

declare(strict_types=1);

namespace App\Handler\Account;

use App\Service\AccountServiceInterface;
use App\Middleware\UserMiddleware;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\InputFilter\InputFilterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RejectHandler implements RequestHandlerInterface
{
    public function __construct(
        private AccountServiceInterface $accountService,
        private InputFilterInterface $accountRejectFilter
    ) {
        $this->accountService      = $accountService;
        $this->accountRejectFilter = $accountRejectFilter;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $user = $request->getAttribute(UserMiddleware::class);

        $body = $request->getParsedBody();

        $this->accountRejectFilter->setData($body);

        if (! $this->accountRejectFilter->isValid()) {
            return new JsonResponse([
                'errors' => $this->accountRejectFilter->getMessages(),
            ], 422);
        }

        $this->accountService->sendRejectNotification(
            $user,
            $this->accountRejectFilter->getValues()['type'],
            $this->accountRejectFilter->getValues()['email'],
        );

        return new JsonResponse([
            'message' => 'Sikeres elutasító e-mail küldés'
        ]);
    }
}
