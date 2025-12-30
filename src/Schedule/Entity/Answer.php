<?php

declare(strict_types=1);

namespace App\Schedule\Entity;

use DateTimeImmutable;

final readonly class Answer
{
    private Id $id;

    private StudentId $studentId;

    private QuestionId $questionId;

    private AnswerOptionId $answerOptionId;

    private bool $isCorrect;

    private DateTimeImmutable $answeredAt;

    public function __construct(
//        Id $id,
        StudentId $studentId,
        QuestionId $questionId,
        AnswerOptionId $answerOptionId,
        bool $isCorrect,
        DateTimeImmutable $answeredAt = new DateTimeImmutable()
    ) {
        $this->id = Uuid::uuid4()->toString();
        $this->studentId = $studentId;
        $this->questionId = $questionId;
        $this->answerOptionId = $answerOptionId;
        $this->isCorrect = $isCorrect;
        $this->answeredAt = $answeredAt;
    }
}
