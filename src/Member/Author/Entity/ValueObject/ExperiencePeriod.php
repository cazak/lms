<?php

declare(strict_types=1);

namespace App\Member\Author\Entity\ValueObject;

use App\Member\Author\Test\Entity\ValueObject\Assert;
use App\Shared\Entity\ValueObject\ValueObject;

final readonly class ExperiencePeriod implements ValueObject
{
    private int $startYear;
    private int $endYear;

    public function __construct(int $startYear, int $endYear)
    {
        Assert::greaterOrEqual($startYear, 1960);
        Assert::greaterOrEqual($endYear, 1960);
        Assert::smallerOrEqual($startYear, date('Y'));
        Assert::smallerOrEqual($endYear, date('Y'));
        Assert::greaterOrEqual($startYear, $endYear);

        $this->startYear = $startYear;
        $this->endYear = $endYear;
    }

    public function getStartYear(): int
    {
        return $this->startYear;
    }

    public function getEndYear(): int
    {
        return $this->endYear;
    }

    /**
     * @param ExperiencePeriod $object
     */
    public function isEqualTo(ValueObject $object): bool
    {
        return $object->getStartYear() === $this->startYear && $object->getEndYear() === $this->endYear;
    }
}
