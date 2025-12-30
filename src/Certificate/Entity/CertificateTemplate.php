<?php

declare(strict_types=1);

namespace App\Certificate\Entity;

use App\Certificate\Entity\ValueObject\CourseId;
use App\Certificate\Entity\ValueObject\Style;
use DateTimeImmutable;

final class CertificateTemplate
{
    private readonly Id $id;

    private readonly CourseId $courseId;

    private readonly Style $style; // Gold, Blue, Silver

    private ?string $backgroundImage = null;
}
