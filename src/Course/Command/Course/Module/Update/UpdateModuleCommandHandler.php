<?php

declare(strict_types=1);

namespace App\Course\Command\Course\Module\Update;

final readonly class UpdateModuleCommandHandler
{
    public function __construct()
    {
    }

    public function __invoke(UpdateModuleCommand $command): void
    {
        $course = $this->repository->findCourseById($command->courseId);

        $course->updateModuleName(
            $command->moduleId,
            $command->name,
        );

        $this->flusher->flush();
    }
}
