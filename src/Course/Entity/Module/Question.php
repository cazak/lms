<?php

declare(strict_types=1);

namespace App\Course\Entity\Module;

use App\Course\Entity\Id;
use App\Course\Entity\LectureId;
use App\Course\Entity\Uuid;
use DomainException;

final class Question
{
    private readonly Id $id;

    private readonly LectureId $lectureId;

    private string $name;

    /**
     * @var Collection<int, AnswerOption>
     */
    private Collection $answerOptions;

    public function __construct(LectureId $lectureId, string $name, array $choices, string $answer)
    {
        $this->id = Id::generate();
        $this->lectureId = $lectureId;
        $this->name = $name;
        $this->answerOptions = new ArrayCollection();

        $foundCorrect = false;

        foreach ($choices as $choice) {
            $isCorrect = ($choice === $answer);
            $this->answerOptions->add(
                new AnswerOption($this, $choice, $isCorrect)
            );

            if ($isCorrect) {
                $foundCorrect = true;
            }
        }

        if (!$foundCorrect) {
            throw new DomainException('Correct answer must be one of choices');
        }

        $this->assertSingleAnswer();
    }

    private function assertSingleAnswer(): void
    {
        $correctAnswers = count(array_filter(
            $this->answerOptions->toArray(),
            static fn (AnswerOption $answerOption) => $answerOption->isCorrect()
        ));

        if ($correctAnswers !== 1) {
            throw new DomainException('Question must have exactly one correct answer');
        }
    }
}
