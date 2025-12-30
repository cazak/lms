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
final class ExpiresTest extends TestCase
{
    public function testSuccess(): void
    {
        $token = new Token(
            mb_strtoupper(Uuid::uuid4()->toString()),
            $expires = new DateTimeImmutable(),
        );

        self::assertTrue($token->isExpired($expires));
        self::assertFalse($token->isExpired($expires->modify('-1 second')));
        self::assertTrue($token->isExpired($expires->modify('+1 day')));
    }
}
