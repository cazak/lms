<?php

declare(strict_types=1);

namespace App\Course\Command\Course\Module\Lecture\Update;

use App\Course\Entity\Module\DTO\QuestionDTO;
use App\Course\Entity\Module\ValueObject\Content;

final readonly class UpdateLectureCommandHandler
{
    public function __invoke(UpdateLectureCommand $command): void
    {
        $course = $this->repository->findCourseById($command->courseId);

        $questions = array_map($command->questions, function (array $question) {
            return new QuestionDTO($question['name'], $question['answer'], $question['choices']);
        });

        $course->updateLecture(
            $course->moduleId,
            $course->lectureId,
            $command->name,
            new Content(
                $command->type,
                $command->content,
                $command->duration,
            ),
            $questions
        );

        $this->flusher->flush();
    }
}
