<?php

declare(strict_types=1);

namespace App\Course\Entity\ValueObject;

use App\Shared\Entity\ValueObject\ValueObject;

final readonly class AccessTime implements ValueObject
{
    private const string LIFETIME = 'lifetime';
    private const string MONTH = 'month';
    private const string THREE_MONTH = 'three_month';
    private const string SIX_MONTH = 'six_month';

    private string $value;

    private function __construct(string $value)
    {
        Assert::oneOf($value, [
            self::LIFETIME,
            self::MONTH,
            self::THREE_MONTH,
            self::SIX_MONTH,
        ]);

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param AccessTime $object
     */
    public function isEqualTo(ValueObject $object): bool
    {
        return $this->value === $object->getValue();
    }
}
