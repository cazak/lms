<?php

declare(strict_types=1);

namespace App\Schedule\Command\Cancel;

//use App\Schedule\Entity\Schedule;

use App\Schedule\Command\DateTimeImmutable;
use App\Schedule\Command\Id;
use App\Schedule\Command\Schedule;

final readonly class CancelScheduleCommandHandler
{
    public function __invoke(CancelScheduleCommand $command): void
    {
        $schedule = $this->repository->findScheduleByStudentAndCourse($command->courseId, $command->studentId);

        if ($schedule->isCanceled()) {
            throw new Exception('Schedule already canceled');
        }

        $schedule->cancel();
        $this->flusher->flush();
    }
}
