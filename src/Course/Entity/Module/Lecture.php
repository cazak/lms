<?php

declare(strict_types=1);

namespace App\Course\Entity\Module;

use App\Course\Entity\ArrayCollection;
use App\Course\Entity\Collection;
use App\Course\Entity\Id;
use App\Course\Entity\Module\DTO\LectureDTO;
use App\Course\Entity\Module\DTO\QuestionDTO;
use App\Course\Entity\Module\ValueObject\Content;
use App\Course\Entity\Uuid;
use DomainException;

/**
 * @internal
 */
final class Lecture
{
    private readonly Id $id;

    private readonly Module $module;

    private string $name;

    private Content $content;

    /** @var Collection<int, Question> */
    private Collection $questions;

    public function __construct(
        Module $module,
        LectureDTO $lectureDTO,
    ) {
        $this->id = Uuid::uuid4()->toString();
        $this->module = $module;
        $this->name = $lectureDTO->name;
        $this->content = $lectureDTO->content;
        $this->questions = new ArrayCollection();

        foreach ($lectureDTO->questions as $question) {
            $this->questions->add(
                new Question(
                    $this->id,
                    $question->name,
                    $question->choices,
                    $question->answer
                )
            );
        }
    }

    public function update(string $name, Content $content): void
    {
        $this->name = $name;
        $this->content = $content;
    }

    /**
     * @param list<QuestionDTO> $questions
     */
    public function updateQuestions(array $questions): void
    {
        $this->questions->clear();
        foreach ($questions as $question) {
            $this->questions->add(
                new Question(
                    $this->id,
                    $question->name,
                    $question->choices,
                    $question->answer
                )
            );
        }
    }

    public function addQuestion(Question $question): void
    {
        foreach ($this->questions as $existingQuestion) {
            if ($existingQuestion->contains($question)) {
                throw new DomainException('Question already exists');
            }
        }

        $this->questions->add($question);
    }
}
