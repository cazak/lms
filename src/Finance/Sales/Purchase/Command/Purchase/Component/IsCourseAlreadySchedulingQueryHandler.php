<?php

declare(strict_types=1);

namespace App\Finance\Sales\Purchase\Command\Purchase\Component;

final readonly class IsCourseAlreadySchedulingQueryHandler
{
    public function __invoke(IsCourseAlreadySchedulingQuery $query)
    {
        // return dto;
        return $this->createQuery()->find('from schedule where course.id = :courseId and student.id = :studentId');
    }
}
