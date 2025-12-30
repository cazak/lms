<?php

declare(strict_types=1);

namespace App\Schedule\Entity\ValueObject;

use App\Course\Entity\ValueObject\Assert;
use App\Shared\Entity\ValueObject\ValueObject;

final readonly class Status implements ValueObject
{
    public const string ACTIVE = 'active';
    public const string EXPIRED = 'expired';
    public const string CANCELED = 'canceled';
    public const string COMPLETED = 'completed';

    private string $value;

    public function __construct(string $value)
    {
        Assert::oneOf($value, [
            self::ACTIVE,
            self::EXPIRED,
            self::CANCELED,
            self::COMPLETED,
        ]);

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isCompleted(): bool
    {
        return $this->value === self::COMPLETED;
    }

    /**
     * @param Status $object
     */
    public function isEqualTo(ValueObject $object): bool
    {
        return $this->value === $object->getValue();
    }
}
