<?php

declare(strict_types=1);

namespace App\Schedule\Entity;

/**
 * Счет скорее всего будет просто в команде, это не нужно, а Answer[] будет в Schedule
 */
final readonly class Progress
{
    private Id $id;

    private Schedule $schedule;

    /** @var Collection<int, Answer> */
    private Collection $answers;

    private int $percentage;
}
