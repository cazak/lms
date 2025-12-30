<?php

declare(strict_types=1);

namespace App\Member\Author\Entity\ValueObject;

use App\Shared\Entity\ValueObject\ValueObject;

final readonly class Id implements ValueObject
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::uuid($value);
        $this->value = mb_strtolower($value);
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param Id $object
     */
    public function isEqualTo(ValueObject $object): bool
    {
        return $this->value === $object->getValue();
    }
}
