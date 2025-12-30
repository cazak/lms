<?php

declare(strict_types=1);

namespace App\Course\Command\Course\Module\Lecture\Remove;

final readonly class RemoveLectureCommandHandler
{
    public function __invoke(RemoveLectureCommand $command): void
    {
        $course = $this->repository->findCourseById($command->courseId);

        $course->removeLecture(
            $command->moduleId,
            $command->lectureId,
        );
    }
}
