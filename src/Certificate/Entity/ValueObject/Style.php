<?php

declare(strict_types=1);

namespace App\Certificate\Entity\ValueObject;

use App\Shared\Entity\ValueObject\ValueObject;

enum Style: string implements ValueObject
{
    case Blue = 'blue';
    case Gold = 'gold';
    case Silver = 'silver';

    /** @return array<string> */
    public static function casesAtString(): array
    {
        return array_map(static fn (self $type): string => $type->value, self::cases());
    }

    /**
     * @param Style $object
     */
    public function isEqualTo(ValueObject $object): bool
    {
        return $this->value === $object->value;
    }
}
