<?php

declare(strict_types=1);

namespace App\Finance\Sales\Purchase\Entity\Event;

use App\Sales\Entity\Event\CourseId;
use App\Sales\Entity\Event\PurchaseId;
use App\Sales\Entity\Event\StudentId;

final readonly class PurchaseCreatedEvent
{
    public function __construct(
        public PurchaseId $purchaseId,
        public CourseId $courseId,
        public StudentId $studentId,
    ) {
    }
}
