<?php

declare(strict_types=1);

namespace App\Member\Author\Entity\ValueObject;

use App\Shared\Entity\ValueObject\ValueObject;
use Webmozart\Assert\Assert;

final readonly class WorkingTime implements ValueObject
{
    private const array DAYS = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];

    private array $days;
    private int $startTime;
    private int $endTime;

    public function __construct(array $days, int $startTime, int $endTime)
    {
        Assert::allInArray($days, self::DAYS);
        Assert::greaterThan($startTime, $endTime);
        Assert::between($startTime, 0, 23);
        Assert::between($endTime, 0, 23);

        $this->days = $days;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    /**
     * @param WorkingTime $object
     */
    public function isEqualTo(ValueObject $object): bool
    {
        return $this->days === $object->days &&
            $this->startTime === $object->startTime &&
            $this->endTime === $object->endTime;
    }
}
