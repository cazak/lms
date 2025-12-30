<?php

declare(strict_types=1);

namespace App\Member\Student\Entity;

final readonly class Student
{
    private Id $id;

    /** @var Collection<int, CompletedCourse> */
    private Collection $completedCourses;
}
