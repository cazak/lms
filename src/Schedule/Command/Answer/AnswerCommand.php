<?php

declare(strict_types=1);

namespace App\Schedule\Command\Answer;

final readonly class AnswerCommand
{
    public function __construct(
        public string $questionId,
        public string $answer,
    ) {
    }
}
