<?php

declare(strict_types=1);

namespace App\Handler\Account;

use App\Service\AccountServiceInterface;
use App\Middleware\UserMiddleware;
use DateTime;
use Dompdf\Dompdf;
use Laminas\Diactoros\Stream;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\InputFilter\InputFilterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function ob_start;
use function ob_get_clean;
use function fopen;
use function fputs;
use function rewind;
use function strval;

final class PrintHandler implements RequestHandlerInterface
{
    public function __construct(
        private AccountServiceInterface $accountService,
        private InputFilterInterface $accountPrintFilter
    ) {
        $this->accountService     = $accountService;
        $this->accountPrintFilter = $accountPrintFilter;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $user = $request->getAttribute(UserMiddleware::class);

        $body = $request->getParsedBody();

        $this->accountPrintFilter->setData($body);

        if (! $this->accountPrintFilter->isValid()) {
            return new JsonResponse([
                'errors' => $this->accountPrintFilter->getMessages(),
            ], 422);
        }

        $pdf = $this->accountService->printAccount(
            $user,
            $this->accountPrintFilter->getValues()['id'],
        );

        if ($pdf !== null) {
            $stream = $this->getStream($pdf);

            $date = (new DateTime())->format('Y-m-d-H-i-s');

            return new Response($stream, 200, [
                'Content-Type'              => 'application/pdf',
                'Content-Disposition'       => 'attachment; filename="LGY-KOD-'. $date .'.pdf"',
                'Content-Transfer-Encoding' => 'Binary',
                'Content-Description'       => 'File Transfer',
                'Pragma'                    => 'public',
                'Expires'                   => '0',
                'Cache-Control'             => 'must-revalidate',
                'Content-Length'            => strval($stream->getSize()),
            ]);
        }

        return new JsonResponse([
            'message' => 'Sikertelen az egyedi azonosító lap létrehozása'
        ], 500);
    }

    private function getStream(Dompdf $pdf): Stream
    {
        $stream = $pdf->output();

        ob_start();
        ob_get_clean();

        $stream = fopen('php://memory', 'wb+');

        fputs($stream, $pdf->output());

        rewind($stream);

        return new Stream($stream);
    }
}
