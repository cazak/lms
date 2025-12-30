<?php

declare(strict_types=1);

namespace App\User\Test\Entity;

use App\User\Entity\Email;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Email::class)]
final class EmailTest extends TestCase
{
    public function testCreate(): void
    {
        $email = new Email('teST@test.com');

        self::assertSame('test@test.com', $email->getValue());
    }

    public function testErrorOnEmpty(): void
    {
        self::expectException(InvalidArgumentException::class);
        new Email('');
    }

    public function testErrorOnIncorrectId(): void
    {
        self::expectException(InvalidArgumentException::class);
        new Email('incorrect-email');
    }
}
