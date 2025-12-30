<?php

declare(strict_types=1);

namespace App\Schedule\Command\Answer;

use App\Schedule\Entity\Answer;

final readonly class AnswerCommandHandler
{
    public function __invoke(AnswerCommand $command): void
    {
        $isAnswerCorrect = $this->getAnswerIsCorrect($command->answerOptionId);
        $schedule = $this->findLastScheduleByCourseAndStudent($command->courseId, $command->studentId);

        $answer = new Answer(
            $command->studentId,
            $command->questionId,
            $command->answerOptionId,
            $isAnswerCorrect
        );

        $schedule->addAnswer($answer);
        $this->flusher->flush();
    }
}
