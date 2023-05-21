<?php

declare(strict_types=1);

namespace App\Handler\Account;

use App\Service\AccountServiceInterface;
use App\Exception\TooManyResultsException;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\InputFilter\InputFilterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class SearchHandler implements RequestHandlerInterface
{
    public function __construct(
        private AccountServiceInterface $accountService,
        private InputFilterInterface $accountSearchFilter
    ) {
        $this->accountService      = $accountService;
        $this->accountSearchFilter = $accountSearchFilter;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody();

        $this->accountSearchFilter->setData($body);

        if (! $this->accountSearchFilter->isValid()) {
            return new JsonResponse([
                'errors' => $this->accountSearchFilter->getMessages(),
            ], 422);
        }

        try {
            $accounts = $this->accountService->getAccounts(
                $this->accountSearchFilter->getValues()['zip_code'],
                $this->accountSearchFilter->getValues()['name'],
                $this->accountSearchFilter->getValues()['address'],
            );
        } catch (TooManyResultsException $e) {
            return new JsonResponse([
                'error' => 'Keresés a rendszer által elutasítva. A találatok száma több, mint 50. Pontosíts a keresésen.'
            ], 422);
        }

        $normalizedAccounts = [];

        foreach ($accounts as $account) {
            $normalizedAccounts[] = $account->normalizer(null, ['groups' => 'list']);
        }

        return new JsonResponse([
            'data' => $normalizedAccounts
        ]);
    }
}
