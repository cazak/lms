<?php

declare(strict_types=1);

namespace App\Certificate\Entity\ValueObject;

use App\Shared\Entity\ValueObject\ValueObject;

final readonly class CourseId implements ValueObject
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
     * @param CourseId $object
     */
    public function isEqualTo(ValueObject $object): bool
    {
        return $this->value === $object->getValue();
    }
}
