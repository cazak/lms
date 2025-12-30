<?php

declare(strict_types=1);

namespace App\Member\Author\Test\Entity\ValueObject;

use InvalidArgumentException;

final class WorkingTimeTest
{
    public function testSuccess(): void
    {
        $working = new WorkingTime(['tuesday', 'thursday'], 14, 16);

        self::assertEquals(['tuesday', 'thursday'], $working->getDays());
        self::assertEquals(14, $working->getStartHour());
        self::assertEquals(16, $working->getEndHour());
    }

    public function testIncorrectDays(): void
    {
        self::expectException(InvalidArgumentException::class);

        new WorkingTime(['incorrect-day'], 14, 16);
    }

    public function testIncorrectHours(): void
    {
        self::expectException(InvalidArgumentException::class);

        new WorkingTime(['monday'], 14, 25);
    }
}
