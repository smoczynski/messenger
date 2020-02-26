<?php
declare(strict_types=1);

namespace App\EventSubscriber;

use App\Exception\ValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Validator\ConstraintViolationInterface;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'handleException'
        ];
    }

    public function handleException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        switch (true) {
            case $throwable instanceof ValidationException:
                $result = $this->handleValidationException($throwable);
                break;
            default:
                $result = $throwable->getMessage();
        }

        $event->setResponse(
            new JsonResponse($result, JsonResponse::HTTP_BAD_REQUEST)
        );
    }

    private function handleValidationException(ValidationException $exception): array
    {
        $response = [
            'message' => $exception->getMessage(),
            'errors' => [],
        ];

        /** @var ConstraintViolationInterface $violation */
        foreach ($exception->getViolations() as $violation) {
            $response['errors'][] = $violation->getPropertyPath() . ' - ' . $violation->getMessage();
        }

        return $response;
    }
}
