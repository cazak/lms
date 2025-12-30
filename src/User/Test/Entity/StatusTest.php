<?php

declare(strict_types=1);

namespace App\User\Test\Entity;

use App\User\Entity\Status;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Status::class)]
final class StatusTest extends TestCase
{
    public function testCreate(): void
    {
        $status = Status::wait();

        self::assertSame(Status::WAIT, $status->getValue());

        self::assertFalse($status->isConfirmed());
        self::assertTrue($status->isWait());
    }

    public function testIncorrectStatus(): void
    {
        self::expectException(InvalidArgumentException::class);
        new Status('incorrectRole');
    }

    public function testErrorOnEmpty(): void
    {
        self::expectException(InvalidArgumentException::class);
        new Status('');
    }
}
