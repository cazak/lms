<?php

namespace App\User\Entity;

use Webmozart\Assert\Assert;

final readonly class Role
{
    public const string USER = 'user';
    public const string ADMIN = 'admin';

    /**
     * @var non-empty-string
     */
    private string $value;

    public function __construct(string $role)
    {
        Assert::oneOf(
            $role,
            [
                self::USER,
                self::ADMIN
            ]
        );
        $this->value = $role;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public static function user(): self
    {
        return new self(self::USER);
    }

    public static function admin(): self
    {
        return new self(self::ADMIN);
    }

    public function isAdmin(): bool
    {
        return $this->value === self::ADMIN;
    }

    public function isUser(): bool
    {
        return $this->value === self::USER;
    }
}
