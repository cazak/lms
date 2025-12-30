<?php

declare(strict_types=1);

namespace App\Member\Student\Entity;

use DateTimeImmutable;

/**
 * Не надо создавать эту сущность. Можно просто по Schedule смотреть, по статусу там
 */
final readonly class CompletedCourse
{
    private Id $id;

    private StudentId $studentId;

    private CourseId $courseId;

    private ?CertificateId $certificateId;

    private DateTimeImmutable $completedAt;
}
