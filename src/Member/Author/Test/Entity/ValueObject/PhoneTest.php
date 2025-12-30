<?php

declare(strict_types=1);

namespace App\Member\Author\Test\Entity\ValueObject;

use InvalidArgumentException;

final class PhoneTest
{
    public function testSuccess(): void
    {
        $phone = new Phone('+15557890111');

        self::assertEquals('+15557890111', $phone->getValue());
    }

    public function testErrorOnEmpty(): void
    {
        self::expectException(InvalidArgumentException::class);

        new Phone('');
    }

    public function testErrorOnInvalidPhone(): void
    {
        self::expectException(InvalidArgumentException::class);

        new Phone('incorrect-phone');
    }

    public function testErrorOnLargeDigitsCount(): void
    {
        self::expectException(InvalidArgumentException::class);

        new Phone('+1234515557890111');
    }

    public function testErrorOnSmallDigitsCount(): void
    {
        self::expectException(InvalidArgumentException::class);

        new Phone('+1234515557');
    }

    public function testErrorNoPlusSign(): void
    {
        self::expectException(InvalidArgumentException::class);

        new Phone('11234515557');
    }
}
