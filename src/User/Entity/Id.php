<?php

namespace App\User\Entity;

use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

final readonly class Id
{
    /**
     * @var non-empty-string
     */
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
     * @return non-empty-string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
