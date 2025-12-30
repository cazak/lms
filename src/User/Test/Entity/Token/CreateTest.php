<?php

declare(strict_types=1);

namespace App\User\Test\Entity\Token;

use App\User\Entity\Token;
use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

#[CoversClass(Token::class)]
final class CreateTest extends TestCase
{
    public function testCreate(): void
    {
        $token = new Token(
            $uuid = mb_strtoupper(Uuid::uuid4()->toString()),
            $expires = new DateTimeImmutable(),
        );

        self::assertSame(mb_strtolower($uuid), $token->getValue());
        self::assertSame($expires, $token->getExpires());
    }

    public function testErrorOnEmpty(): void
    {
        self::expectException(InvalidArgumentException::class);

        new Token(
            '',
            new DateTimeImmutable(),
        );
    }

    public function testErrorOnInvalidToken(): void
    {
        self::expectException(InvalidArgumentException::class);

        new Token(
            'invalid-token',
            new DateTimeImmutable(),
        );
    }
}
