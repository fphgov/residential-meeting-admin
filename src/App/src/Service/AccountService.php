<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Account;
use App\Entity\NotificationInterface;
use App\Model\SimpleNotification;
use App\Repository\AccountRepository;
use App\Service\MailServiceInterface;
use App\Exception\TooManyResultsException;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Pdf\Interfaces\PdfRender;
use Laminas\Log\Logger;

final class AccountService implements AccountServiceInterface
{
    private AccountRepository $accountRepository;

    public function __construct(
        private array $config,
        private EntityManagerInterface $em,
        private Logger $audit,
        private MailServiceInterface $mailService,
        private PdfRender $pdfRender
    ) {
        $this->config            = $config;
        $this->em                = $em;
        $this->audit             = $audit;
        $this->mailService       = $mailService;
        $this->pdfRender         = $pdfRender;
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

        if (count($accounts) >= 50) {
            throw new TooManyResultsException('Too many result in account query');
        }

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

    public function printAccounts(string $id): ?Dompdf
    {
        $account = $this->accountRepository->find($id);

        if ($account) {
            return $this->printAuthCodeEmail($account);
        }

        return null;
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

    private function printAuthCodeEmail(Account $account): Dompdf
    {
        $tplData = [
            'authCode' => $account->getAuthCode(),
        ];

        $dompdf = new Dompdf();
        $dompdf->loadHtml($this->pdfRender->render('pdf/result', $tplData));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf;
    }
}
