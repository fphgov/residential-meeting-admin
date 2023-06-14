<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\MailLog;
use App\Repository\MailLogRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class MailLogExportModel implements ExportCsvModelInterface
{
    public const HEADER = [
        'id',
        'message_id',
        'name',
        'created_at',
        'updated_at',
    ];

    /** @var MailLogRepositoryInterface **/
    private $mailLogRepository;

    public function __construct(
        private EntityManagerInterface $em
    ) {
        $this->em                = $em;
        $this->mailLogRepository = $this->em->getRepository(MailLog::class);
    }

    public function getCsvData(): array
    {
        $mailLogs = $this->mailLogRepository->findAll();

        $exportData = [];

        $exportData[] = self::HEADER;

        foreach ($mailLogs as $mailLog) {
            $data = [
                $mailLog->getId(),
                $mailLog->getMessageId(),
                $mailLog->getName(),
                $mailLog->getCreatedAt()->format(self::DATE_FORMAT),
                $mailLog->getUpdatedAt()->format(self::DATE_FORMAT),
            ];

            $exportData[] = $data;
        }

        return $exportData;
    }
}
