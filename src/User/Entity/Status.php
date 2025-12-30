<?php

namespace App\User\Entity;

use Webmozart\Assert\Assert;

final readonly class Status
{
    public const string CONFIRMED = 'confirmed';
    public const string WAIT = 'wait';

    /**
     * @var non-empty-string
     */
    private string $value;

    public function __construct(string $status)
    {
        Assert::oneOf(
            $status,
            [
                self::CONFIRMED,
                self::WAIT
            ]
        );
        $this->value = $status;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public static function wait(): self
    {
        return new self(self::WAIT);
    }

    public static function confirmed(): self
    {
        return new self(self::CONFIRMED);
    }

    public function isConfirmed(): bool
    {
        return $this->value === self::CONFIRMED;
    }

    public function isWait(): bool
    {
        return $this->value === self::WAIT;
    }
}
