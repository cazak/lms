<?php

declare(strict_types=1);

namespace App\User\Test\Service;

use App\User\Service\PasswordHasher;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PasswordHasher::class)]
final class PasswordHasherTest extends TestCase
{
    public function testHash(): void
    {
        $passwordHasher = new PasswordHasher(16);
        $hash = $passwordHasher->hash('password');

        self::assertNotSame('password', $hash);
    }

    public function testValidate(): void
    {
        $passwordHasher = new PasswordHasher(16);
        $hash = $passwordHasher->hash('password');

        self::assertTrue($passwordHasher->verify('password', $hash));
    }
}
