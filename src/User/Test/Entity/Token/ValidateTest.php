<?php

declare(strict_types=1);

namespace App\User\Test\Entity\Token;

use App\User\Entity\Token;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

#[CoversClass(Token::class)]
final class ValidateTest extends TestCase
{
    public function testSuccess(): void
    {
        $token = new Token(
            $uuid = mb_strtoupper(Uuid::uuid4()->toString()),
            $expires = new DateTimeImmutable(),
        );

        self::assertTrue($token->validate($uuid, $expires->modify('-1 day')));
    }

    public function testExpired(): void
    {
        $token = new Token(
            $uuid = mb_strtoupper(Uuid::uuid4()->toString()),
            $expires = new DateTimeImmutable(),
        );

        self::expectExceptionMessage('Token is expired.');
        $token->validate($uuid, $expires);
    }

    public function testOtherToken(): void
    {
        $token = new Token(
            mb_strtoupper(Uuid::uuid4()->toString()),
            $expires = new DateTimeImmutable(),
        );

        self::expectExceptionMessage('Token is invalid.');
        $token->validate(Uuid::uuid4()->toString(), $expires->modify('-1 day'));
    }
}
