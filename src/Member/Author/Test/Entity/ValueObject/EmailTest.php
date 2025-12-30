<?php

declare(strict_types=1);

namespace App\Member\Author\Test\Entity\ValueObject;

use InvalidArgumentException;

final class EmailTest
{
    public function testSuccess(): void
    {
        $email = new Email('tESt@test.test');

        self::assertEquals('test@test.test', $email->getValue());
    }

    public function testErrorOnEmpty(): void
    {
        self::expectException(InvalidArgumentException::class);

        new Email('');
    }

    public function testErrorOnInvalidEmail(): void
    {
        self::expectException(InvalidArgumentException::class);

        new Email('incorrect-email');
    }
}
