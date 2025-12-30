<?php

declare(strict_types=1);

namespace App\Course\Test\Entity\Create;

final class CreateTest
{
    public function success()
    {
        $course = $this->createCourse();

        self::assertTrue($course->isDraft());
        self::assertFalse($course->isPublished());
    }

    public function errorOnSellNotReady(): void
    {
        $course = $this->createCourse();

        self::expectExceptionMessage('Course is not ready for selling.');
        $course->startSell();
    }

    public function errorOnSellNotApproved(): void
    {
        $course = $this->createCourse();

        $course->publish();
        self::expectExceptionMessage('Course is not ready for selling.');
        $course->startSell();
    }

    public function successOnSellApproved(): void
    {
        $course = $this->createCourse();

        $course->publish();
        $course->approve();

        $course->startSell();

        self::assertTrue($course->isSelling());
    }

    private function createCourse(?array $modules = null)
    {
        return Course::create(
            Id::generate(),
            $authorId = new AuthorId(),
            $modules ??= Module::create(
                Id::generate(),
                'Test name',
                'Description',
                new Lecture(
                    Id::generate(),
                    'Test name',
                )
            ),
            $name = '',
            $description = '',
            $longDescription = '',
            $category = new Category(),

        );
    }
}

/**
 * Создание курса записанного:
 *
 */
