<?php

declare(strict_types=1);

namespace App\User\Test\Entity;

use App\User\Entity\Email;
use App\User\Entity\Id;
use App\User\Entity\Token;
use App\User\Entity\User;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

#[CoversClass(User::class)]
final class RequestTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = new User(
            $id = Id::generate(),
            $password = 'password',
            $email = new Email('test@test.com'),
            $token = new Token(
                Uuid::uuid4()->toString(),
                new DateTimeImmutable(),
            ),
            $createdAt = new DateTimeImmutable(),
        );

        self::assertSame($id, $user->getId());
        self::assertSame($email, $user->getEmail());
        self::assertSame($password, $user->getPassword());
        self::assertSame($createdAt, $user->getCreatedAt());
        self::assertSame($token, $user->getConfirmationToken());

        self::assertTrue($user->isWait());
    }
}
