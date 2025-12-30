<?php

declare(strict_types=1);

namespace App\Certificate\Entity;

use App\Schedule\Certificate\Entity\CourseId;
use App\Schedule\Certificate\Entity\Id;
use App\Schedule\Certificate\Entity\StudentId;
use DateTimeImmutable;

/**
 * Readonly т.к. не должен меняться
 */
final readonly class Certificate
{
    private Id $id;

    private StudentId $studentId;

    private CourseId $courseId;

    private CertificateTemplate $template;

    private string $path;

    private string $code;

    private DateTimeImmutable $issuedAt;
}
