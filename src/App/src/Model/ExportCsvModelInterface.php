<?php

declare(strict_types=1);

namespace App\Model;

interface ExportCsvModelInterface
{
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    public function getCsvData(): array;
}
