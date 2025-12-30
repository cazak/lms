<?php

declare(strict_types=1);

namespace App\Course\Command\Course\Module\Remove;

final readonly class RemoveModuleCommandHandler
{
    public function __construct()
    {
    }

    public function __invoke(RemoveModuleCommand $command): void
    {
        $course = $this->repository->findCourseById($command->courseId);

        $course->removeModule(
            $command->moduleId
        );

        $this->flusher->flush();
    }
}
