<?php 

namespace App\Form\DataTransformer;

use App\Entity\Session;
use App\Repository\SessionRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class SessionHashTransformer implements DataTransformerInterface
{
    public function __construct(
        private readonly SessionRepository $sessionRepository
    ) {}

    public function transform(mixed $value): ?string
    {
        if (!$value instanceof Session) return null;

        return $value->getHash();
    }

    public function reverseTransform(mixed $value): ?Session
    {
        if ($value === null) return null;

        $value = strtolower($value);
        $session = $this->sessionRepository->findOneBy(['hash' => $value]);

        if (!$session) {
            throw new NotFoundHttpException("Session with hash \"{$value}\" not found.");
        }

        return $session;
    }
}