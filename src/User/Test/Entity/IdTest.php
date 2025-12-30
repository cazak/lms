<?php

declare(strict_types=1);

namespace App\User\Test\Entity;

use App\User\Entity\Id;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

#[CoversClass(Id::class)]
final class IdTest extends TestCase
{
    public function testCreate(): void
    {
        $uuid = Uuid::uuid4()->toString();
        $id = new Id($uuid);

        self::assertSame($uuid, $id->getValue());
    }

    public function testGenerate(): void
    {
        $id = Id::generate();

        self::assertNotEmpty($id->getValue());
    }

    public function testErrorOnEmpty(): void
    {
        self::expectException(InvalidArgumentException::class);
        new Id('');
    }

    public function testErrorOnIncorrectId(): void
    {
        self::expectException(InvalidArgumentException::class);
        new Id('incorrect-uuid');
    }
}
