<?php

declare(strict_types=1);

namespace App\Schedule\EventHandler;

#[AsEventListener]
final readonly class StudentAnsweredEventHandler
{
    public function __construct(
        private CommandBus $commandBus
    ) {
    }

    /**
     * @param StudentAnsweredEvent $event
     */
    public function __invoke(Event $event): void
    {
        $schedule = $this->repository->getSchedule($event->getId());

        $answers = $schedule->getAnswers();

        $correctAnswersCount = count(array_filter($answers, fn (Answer $answer) => $answer->isCorrect()));

        $questions = $this->findQuestionCountOfCourse($schedule->getCourseId());

        if (count($questions) === $correctAnswersCount) {
            if ($correctAnswersCount * count($questions) / 100 >= $this->correctAnswerPercentage) {
                $this->recordEvent(new ScheduleCourseCompletedEvent($schedule->getId()));
            }
        }
    }
}
