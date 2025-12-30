<?php

declare(strict_types=1);

namespace App\Schedule\Command\Start;

use DateTimeImmutable;

final readonly class StartScheduleCommandHandler
{
    public function __construct(private CourseDataQueryHandler $queryHandler)
    {
    }

    public function __invoke(StartScheduleCommand $command): void
    {
        $schedule = $this->findLastScheduleByCourseAndStudent($command->courseId, $command->studentId);
        if ($schedule !== null && $schedule->isActive()) {
            throw new Exception('Schedule is active');
        }

        $courseExpiredAtDTO = $this->queryHandler->findCourseDataById($command->courseId);
        $schedule = new Schedule(
            Id::generate(),
            $command->courseId,
            $command->studentId,
            new DateTimeImmutable()->add($courseExpiredAtDTO),
        );

        $this->repository->save($schedule);
        $this->flusher->flush();
    }
}
