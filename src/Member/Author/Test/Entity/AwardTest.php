<?php

declare(strict_types=1);

namespace App\Member\Author\Test\Entity;

use InvalidArgumentException;

final class AwardTest
{
    public function testSuccess(): void
    {
        $award = new Award(
            2019,
            'Excellence in Teaching Award',
            'MIT Computer Science Department',
            Award::OLYMPIAD, // GRANT, CERTIFICATE
        );

        self::assertTrue($award->isOlympiad());
    }

    public function testIncorrectType(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Award(
            2019,
            'Excellence in Teaching Award',
            'MIT Computer Science Department',
            'Incorrect type',
        );
    }
}
