<?php

declare(strict_types=1);

namespace App\Schedule\Entity\ValueObject;

use App\Shared\Entity\ValueObject\ValueObject;

final readonly class QuestionId implements ValueObject
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::uuid($value);

        $this->value = mb_strtolower($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param QuestionId $object
     */
    public function isEqualTo(ValueObject $object): bool
    {
        return $this->value === $object->getValue();
    }
}
