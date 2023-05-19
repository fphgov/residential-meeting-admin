<?php

declare(strict_types=1);

namespace App\Handler\Account;

use App\Service\AccountServiceInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\InputFilter\InputFilterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class SendHandler implements RequestHandlerInterface
{
    public function __construct(
        private AccountServiceInterface $accountService,
        private InputFilterInterface $accountSendFilter
    ) {
        $this->accountService    = $accountService;
        $this->accountSendFilter = $accountSendFilter;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody();

        $this->accountSendFilter->setData($body);

        if (! $this->accountSendFilter->isValid()) {
            return new JsonResponse([
                'errors' => $this->accountSendFilter->getMessages(),
            ], 422);
        }

        $this->accountService->sendAccounts(
            $this->accountSendFilter->getValues()['id'],
            $this->accountSendFilter->getValues()['email'],
        );

        return new JsonResponse([
            'message' => 'Sikeres egyedi azonosító küldés'
        ]);
    }
}
