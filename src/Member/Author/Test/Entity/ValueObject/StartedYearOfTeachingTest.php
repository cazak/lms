<?php

declare(strict_types=1);

namespace App\Member\Author\Test\Entity\ValueObject;

use DateTimeImmutable;

final class StartedYearOfTeachingTest
{
    public function testSuccess(): void
    {
        $author = new Author(
            Id::generate(),
            new Name('Alexandra', 'Chen'),
            new Email('test@test.com'),
            new Phone('+15557890123'),
            [new Specialization('specialization')],
        );

        $startedYearOfTeaching = 2010;
        $author->setStartedYearOfTeaching($startedYearOfTeaching);

        self::assertEquals($startedYearOfTeaching, $author->getStartedYearOfTeaching());
        self::assertEquals((int)date('Y') - $startedYearOfTeaching, $author->getYearsOfTeaching());
    }

    public function testErrorOnSmall(): void
    {
        $author = new Author(
            Id::generate(),
            new Name('Alexandra', 'Chen'),
            new Email('test@test.com'),
            new Phone('+15557890123'),
            [new Specialization('specialization')],
        );

        self::expectException(InvalidArgumentException::class);
        $author->setStartedYearOfTeaching(1959);
    }

    public function testErrorOnLarge(): void
    {
        $author = new Author(
            Id::generate(),
            new Name('Alexandra', 'Chen'),
            new Email('test@test.com'),
            new Phone('+15557890123'),
            [new Specialization('specialization')],
        );

        self::expectException(InvalidArgumentException::class);
        $author->setStartedYearOfTeaching((int)new DateTimeImmutable()->modify('+1 year')->format('Y'));
    }
}
