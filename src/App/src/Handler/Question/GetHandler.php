<?php

declare(strict_types=1);

namespace App\Handler\Question;

use App\Entity\Question;
use App\Repository\QuestionRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class GetHandler implements RequestHandlerInterface
{
    /** @var QuestionRepositoryInterface **/
    private $questionRepository;

    public function __construct(
        private EntityManagerInterface $em
    ) {
        $this->em                 = $em;
        $this->questionRepository = $this->em->getRepository(Question::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $question = $this->questionRepository->findOneBy([
            'id'     => $request->getAttribute('id'),
            'active' => true,
        ]);

        $normalizedQuestion = $question->normalizer(null, ['groups' => 'detail']);

        return new JsonResponse([
            'question' => $normalizedQuestion,
        ]);
    }
}
