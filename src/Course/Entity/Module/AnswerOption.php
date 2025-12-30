<?php

declare(strict_types=1);

namespace App\Course\Entity\Module;

final readonly class AnswerOption
{
    private Id $id;

    private Question $question;

    private string $answer;

    private bool $isCorrect;

    public function __construct(
        Question $question,
        string $answer,
        bool $isCorrect
    ) {
        $this->id = Uuid::uuid4()->toString();
        $this->question = $question;
        $this->answer = $answer;
        $this->isCorrect = $isCorrect;
    }
}
