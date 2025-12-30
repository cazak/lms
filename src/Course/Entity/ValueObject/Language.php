<?php

declare(strict_types=1);

namespace App\Course\Entity\ValueObject;

use App\Shared\Entity\ValueObject\ValueObject;

enum Language: string implements ValueObject
{
    case Ru = 'ru';
    case En = 'en';

    /** @return array<non-empty-string> */
    public static function casesAtString(): array
    {
        return array_map(static fn (self $language): string => $language->value, self::cases());
    }

    public function isRu(): bool
    {
        return $this->value === Language::Ru->value;
    }

    public function isEn(): bool
    {
        return $this->value === Language::En->value;
    }

    /**
     * @param Language $object
     */
    public function isEqualTo(ValueObject $object): bool
    {
        return $this->value === $object->value;
    }
}
