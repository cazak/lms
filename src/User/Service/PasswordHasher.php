<?php

declare(strict_types=1);

namespace App\User\Service;

use Webmozart\Assert\Assert;

final readonly class PasswordHasher
{
    public function __construct(private int $memoryCost = PASSWORD_ARGON2_DEFAULT_MEMORY_COST)
    {
    }

    /**
     * @param non-empty-string $password
     * @return non-empty-string
     */
    public function hash(string $password): string
    {
        Assert::notEmpty($password);

        return password_hash($password, PASSWORD_ARGON2I, ['memory_cost' => $this->memoryCost]);
    }

    public function verify($password, $hash): bool
    {
        return password_verify($password, $hash);
    }
}
