<?php

declare(strict_types=1);

namespace App\Member\Author\Test\Entity\ValueObject;

use InvalidArgumentException;

final class AvatarTest
{
    public function testSuccess(): void
    {
        $avatar = new Avatar('test.jpg');

        self::assertEquals('test.jpg', $avatar->getValue());
    }

    public function testErrorOnEmpty(): void
    {
        self::expectException(InvalidArgumentException::class);

        new Avatar('');
    }

    public function testErrorOnInvalidAvatar(): void
    {
        self::expectException(InvalidArgumentException::class);

        new Avatar('incorrect-avatar');
    }

    public function testErrorOnAbsenceExtension(): void
    {
        self::expectException(InvalidArgumentException::class);

        new Avatar('test.');
    }

    public function testErrorOnInvalidExtension(): void
    {
        self::expectException(InvalidArgumentException::class);

        new Avatar('test.incorrect');
    }
}
