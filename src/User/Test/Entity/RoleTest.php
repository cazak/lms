<?php

declare(strict_types=1);

namespace App\User\Test\Entity;

use App\User\Entity\Role;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Role::class)]
final class RoleTest extends TestCase
{
    public function testCreate(): void
    {
        $role = new Role('user');

        self::assertSame('user', $role->getValue());
    }

    public function testIncorrectRole(): void
    {
        self::expectException(InvalidArgumentException::class);
        new Role('incorrectRole');
    }

    public function testErrorOnEmpty(): void
    {
        self::expectException(InvalidArgumentException::class);
        new Role('');
    }
}
