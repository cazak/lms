<?php

declare(strict_types=1);

namespace App\Course\Command\Course\Module\Lecture\Create;

use App\Course\Entity\Module\DTO\LectureDTO;
use App\Course\Entity\Module\DTO\QuestionDTO;
use App\Course\Entity\Module\ValueObject\Content;

final readonly class CreateLectureCommandHandler
{
    public function __invoke(CreateLectureCommand $command): void
    {
        $course = $this->repository->findCourseById($command->courseId);

        $questions = array_map($command->questions, function (array $question) {
            return new QuestionDTO($question['name'], $question['answer'], $question['choices']);
        });

        $course->addLectureToModule(
            $course->moduleId,
            new LectureDTO(
                $command->name,
                new Content(
                    ContentType::from($command->type),
                    $command->content,
                    $command->duration,
                ),
                $questions
            )
        );

        $this->flusher->flush();
    }
}
