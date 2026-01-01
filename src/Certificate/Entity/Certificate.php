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

    private Code $code;

    private DateTimeImmutable $issuedAt;

    public function __construct(
        Id $id,
        StudentId $studentId,
        CourseId $courseId,
        CertificateTemplate $template,
        string $path,
        Code $code,
        DateTimeImmutable $issuedAt = new DateTimeImmutable()
    ) {
        $this->id = $id;
        $this->studentId = $studentId;
        $this->courseId = $courseId;
        $this->template = $template;
        $this->path = $path;
        $this->code = $code;
        $this->issuedAt = $issuedAt;
    }
}
