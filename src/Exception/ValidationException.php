<?php
declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationListInterface as ViolationList;
use UnexpectedValueException;

class ValidationException extends UnexpectedValueException
{
    protected ViolationList $violations;

    public function __construct(
        ViolationList $violations,
        $message = 'Validation exception.',
        $code = JsonResponse::HTTP_BAD_REQUEST
    ) {
        $this->violations = $violations;
        parent::__construct($message, $code);
    }

    public function getViolations(): ViolationList
    {
        return $this->violations;
    }
}
