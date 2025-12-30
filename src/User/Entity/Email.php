<?php

namespace App\User\Entity;

use Webmozart\Assert\Assert;

final readonly class Email
{
    /**
     * @var non-empty-string
     */
    private string $value;

    public function __construct(string $value)
    {
        Assert::email($value);
        $this->value = mb_strtolower($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
