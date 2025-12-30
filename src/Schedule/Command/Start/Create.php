<?php

declare(strict_types=1);

namespace App\Schedule\Command\Start;

use App\Schedule\Command\CohortCourseExpiredEvent;
use App\Schedule\Command\CohortCourseWarningExpiredEvent;

/**
 * Создание происходит либо по крону (period у cohort курса)
 * Либо после публикации и проходжения можерации у записанного курса
 *
 */
final readonly class CreateHandler
{
    public function __invoke($command): void
    {
        $schedule = new Schedule(
            $command->courseId,
            $command->startDate,
            $command->endDate
        );
    }
}

final class AddComment
{
    public function __invoke($command): void
    {
    }
}

final class CheckCohortCourseOnReady
{
    public function __invoke($command): void
    {
        if ($course->hasModule($schedule->getCurrentModule())) {

        }

        if ($schedule->isExpired()) {
            if ($schedule->hasWarningOnExpired() && $schedule->is24HoursAgo()) {
                $schedule->expire();
                new CohortCourseExpiredEvent();

                return;
            }

            new CohortCourseWarningExpiredEvent();
            $schedule->warn();
        }
    }
}
