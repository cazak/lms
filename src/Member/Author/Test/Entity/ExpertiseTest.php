<?php

declare(strict_types=1);

namespace App\Member\Author\Test\Entity;

use InvalidArgumentException;

final class ExpertiseTest
{
    public function testSuccess(): void
    {
        $expertise = new Expertise('Artificial Intelligence', new Avatar('artificial_intelligence.jpg'));

        self::assertEquals('Artificial Intelligence', $expertise->getName());
    }
}
