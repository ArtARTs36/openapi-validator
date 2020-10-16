<?php

namespace ArtARTs36\OpenApiValidator;

class ValidInfo
{
    protected $errorsCount;

    protected $warningsCount;

    protected $errors;

    public function __construct(int $errorsCount, int $warningsCount, ?array $errors = [])
    {
        $this->errorsCount = $errorsCount;
        $this->warningsCount = $warningsCount;
        $this->errors = $errors;
    }

    public function errorsCount(): int
    {
        return $this->errorsCount;
    }

    public function warningsCount(): int
    {
        return $this->warningsCount;
    }

    public function isErrorsAllowed(int $max): int
    {
        return $this->errorsCount <= $max;
    }

    public function isWarningsAllowed(int $max): int
    {
        return $this->warningsCount <= $max;
    }

    public function isValid(int $errorsMax, int $warningsMax): bool
    {
        return $this->isErrorsAllowed($errorsMax) && $this->isWarningsAllowed($warningsMax);
    }

    public function isNotValid(int $errorsMax, int $warningsMax): bool
    {
        return ! $this->isValid(...func_get_args());
    }

    public function errors(): ?array
    {
        return $this->errors;
    }
}
