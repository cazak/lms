<?php

declare(strict_types=1);

namespace App\Course\Command\Course\Module\Create;

final readonly class CreateModuleCommandHandler
{
    public function __construct()
    {
    }

    public function __invoke(CreateModuleCommand $command): void
    {
        $course = $this->repository->findCourseById($command->courseId);

        $course->addModule(
            new Module($course, $command->name),
        );

        $this->repository->add($course);
        $this->flusher->flush();
    }
}
