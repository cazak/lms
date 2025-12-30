<?php

declare(strict_types=1);

namespace App\Course\Entity\ValueObject;

use App\Shared\Entity\ValueObject\ValueObject;

enum DifficultyLevel: string implements ValueObject
{
    case Beginner = 'beginner';
    case Intermediate = 'intermediate';
    case Advanced = 'advanced';

    /** @return array<string> */
    public static function casesAtString(): array
    {
        return array_map(static fn (self $level): string => $level->value, self::cases());
    }

    /**
     * @param DifficultyLevel $object
     */
    public function isEqualTo(ValueObject $object): bool
    {
        return $this->value === $object->value;
    }
}
