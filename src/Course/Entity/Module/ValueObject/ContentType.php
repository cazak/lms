<?php

declare(strict_types=1);

namespace App\Course\Entity\Module\ValueObject;

use App\Shared\Entity\ValueObject\ValueObject;

enum ContentType: string implements ValueObject
{
    case Text = 'text';
    case Video = 'video';

    /** @return array<string> */
    public static function casesAtString(): array
    {
        return array_map(static fn (self $type): string => $type->value, self::cases());
    }

    public function isText(): bool
    {
        return $this->value === ContentType::Text->value;
    }

    public function isVideo(): bool
    {
        return $this->value === ContentType::Video->value;
    }

    /**
     * @param ContentType $object
     */
    public function isEqualTo(ValueObject $object): bool
    {
        return $this->value === $object->value;
    }
}
