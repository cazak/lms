<?php

declare(strict_types=1);

namespace App\Member\Author\Entity;

use App\Member\Author\Entity\ValueObject\ExperiencePeriod;
use App\Member\Author\Entity\ValueObject\Id;

final readonly class Experience
{
    private Id $id;

    private ExperiencePeriod $period;

    private string $position;

    private string $company;

    private string $description;

    public function __construct(ExperiencePeriod $period, string $position, string $company)
    {
        $this->id = Id::generate();
        $this->period = $period;
        $this->position = $position;
        $this->company = $company;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
