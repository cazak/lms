<?php

declare(strict_types=1);

namespace App\Member\Author\Test\Entity;

use InvalidArgumentException;

final class ExperienceTest
{
    public function testSuccess(): void
    {
        $experience = new Experience(
            2019,
            2021,
            'Lead AI Researcher',
            'TechForward Institute'
        );

        $experience->setDescription('Similique sunt in culpa qui officia deserunt mollitia animi.');

        self::assertEquals($experience->getPeriod()->getStartYear(), 2019);
        self::assertEquals($experience->getPeriod()->getEndYear(), 2021);
    }

    public function testIncorrectYears(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Experience(
            2021,
            2020,
            'Lead AI Researcher',
            'TechForward Institute'
        );
    }
}
