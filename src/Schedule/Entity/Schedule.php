<?php

declare(strict_types=1);

namespace App\Schedule\Entity;

use DateTimeImmutable;
use DomainException;

final class Schedule
{
    private readonly Id $id;

    private readonly PurchaseId $purchaseId;

    private readonly CourseId $courseId;

    private readonly StudentId $studentId;

    /** @var Collection<int, Answer> */
    private Collection $answers;

//    private ?CertificateId $certificateId; // Может не нужно это поле. UPD: лучше сертификат пусть будет сюда ссылаться

    private Status $status; // Завершен, в процессе, просрочен, отменен (например ученик вернул деньги, отказался от курса)

    private readonly DateTimeImmutable $startedAt;

    private DateTimeImmutable $completedAt;

    private DateTimeImmutable $canceledAt;

    private DateTimeImmutable $expiredAt;

    public function __construct(
        Id $id,
        PurchaseId $purchaseId,
        CourseId $courseId,
        StudentId $studentId,
        DateTimeImmutable $expiredAt,
        DateTimeImmutable $startedAt = new DateTimeImmutable()
    ) {
        $this->id = $id;
        $this->purchaseId = $purchaseId;
        $this->courseId = $courseId;
        $this->studentId = $studentId;
        $this->expiredAt = $expiredAt;
        $this->startedAt = $startedAt;
        $this->status = Status::started();
    }

    public function answer(Answer $answer): void
    {
        foreach ($this->answers as $existingAnswer) {
            if ($existingAnswer->equals($answer)) {
                throw new DomainException('Answer already exists.');
            }
        }

        $this->answers->add($answer);
        $this->recordEvent(new StudentAnsweredEvent($this->id, $answer->getQuestionId()));
    }

    public function cancel(): void
    {
        if ($this->status->isCanceled() || $this->status->isCompleted() || $this->status->isExpired()) {
            throw new DomainException('Schedule already canceled.');
        }

        $this->canceledAt = new DateTimeImmutable();
        $this->status = Status::canceled();
    }

    public function expire(): void
    {
        if ($this->status->isExpired()) {
            throw new DomainException('Schedule already expired.');
        }

        $this->expiredAt = new DateTimeImmutable();
        $this->status = Status::expired();
    }

    public function complete(): void
    {
        if ($this->status->isExpired() || $this->status->isCompleted()) {
            throw new DomainException('Can not complete this schedule.');
        }

        $this->completedAt = new DateTimeImmutable();
        $this->status = Status::completed();
    }
}
