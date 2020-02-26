<?php
declare(strict_types=1);

namespace App\Validator;

use App\Exception\ValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function assert($value, $constraints = null, $groups = null): void
    {
        $violations = $this->validator->validate($value, $constraints, $groups);

        if (count($violations) > 0) {
            throw new ValidationException($violations);
        }
    }
}
