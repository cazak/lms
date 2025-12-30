<?php

declare(strict_types=1);

namespace App\User\Test\Entity;

use App\User\Entity\Token;
use App\User\Entity\User;
use App\User\Test\Builder\UserBuilder;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

#[CoversClass(User::class)]
final class ConfirmTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = new UserBuilder()->withConfirmationToken($token = $this->createToken())->build();

        self::assertTrue($user->isWait());
        self::assertFalse($user->isConfirmed());

        $user->confirmSignup(
            $token->getValue(),
            $token->getExpires()->modify('-1 day')
        );

        self::assertFalse($user->isWait());
        self::assertTrue($user->isConfirmed());
    }

    public function testAlreadyConfirmed(): void
    {
        $user = new UserBuilder()->withConfirmationToken($token = $this->createToken())->confirmed()->build();

        self::assertFalse($user->isWait());
        self::assertTrue($user->isConfirmed());

        $this->expectExceptionMessage('User is already confirmed.');

        $user->confirmSignup(
            Uuid::uuid4()->toString(),
            $token->getExpires()->modify('-1 day')
        );
    }

    public function testTokenIsInvalid(): void
    {
        $user = new UserBuilder()->withConfirmationToken($token = $this->createToken())->build();

        self::assertTrue($user->isWait());
        self::assertFalse($user->isConfirmed());

        $this->expectExceptionMessage('Token is invalid.');

        $user->confirmSignup(
            Uuid::uuid4()->toString(),
            $token->getExpires()->modify('-1 day')
        );
    }

    public function testTokenIsExpired(): void
    {
        $user = new UserBuilder()->withConfirmationToken($token = $this->createToken())->build();

        self::assertTrue($user->isWait());
        self::assertFalse($user->isConfirmed());

        $this->expectExceptionMessage('Token is expired.');

        $user->confirmSignup(
            $token->getValue(),
            $token->getExpires(),
        );
    }

    private function createToken(): Token
    {
        return new Token(
            Uuid::uuid4()->toString(),
            new DateTimeImmutable('+1 day'),
        );
    }
}
