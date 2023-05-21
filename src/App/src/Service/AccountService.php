<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Account;
use App\Entity\NotificationInterface;
use App\Model\SimpleNotification;
use App\Repository\AccountRepository;
use App\Service\MailServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Log\Logger;

final class AccountService implements AccountServiceInterface
{
    private AccountRepository $accountRepository;

    public function __construct(
        private array $config,
        private EntityManagerInterface $em,
        private Logger $audit,
        private MailServiceInterface $mailService
    ) {
        $this->config            = $config;
        $this->em                = $em;
        $this->audit             = $audit;
        $this->mailService       = $mailService;
        $this->accountRepository = $this->em->getRepository(Account::class);
    }

    /** @var return \App\Entity\AccountInterface[] */
    public function getAccounts(
        string $zipCode,
        string $name,
        ?string $address,
    ): array
    {
        $accounts = $this->accountRepository->findAccounts(
            $zipCode,
            $name,
            $address
        );

        return $accounts;
    }

    public function sendAccounts(string $id, string $email): void
    {
        $account = $this->accountRepository->find($id);

        if ($account) {
            $notification = new SimpleNotification(
                $id,
                $email
            );

            $this->sendAuthCodeEmail($account, $notification);
        }
    }

    private function sendAuthCodeEmail(Account $account, NotificationInterface $notification): void
    {
        $tplData = [
            'infoMunicipality' => $this->config['app']['municipality'],
            'infoEmail'        => $this->config['app']['email'],
            'authCode'         => $account->getAuthCode(),
        ];

        $this->mailService->send('auth-code', $tplData, $notification);
    }
}
