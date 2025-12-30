<?php

declare(strict_types=1);

namespace App\Course\Entity\ValueObject;

use App\Shared\Entity\ValueObject\ValueObject;

final readonly class Status implements ValueObject
{
    public const string DRAFT = 'draft';
    public const string ON_MODERATION = 'on_moderation';
    public const string PUBLISHED = 'published';
    public const string ON_SELL = 'on_sell';
    public const string ARCHIVED = 'archive';

    private string $value;

    public function __construct(string $value)
    {
        Assert::oneOf($value, [
            self::DRAFT,
            self::ON_MODERATION,
            self::PUBLISHED,
            self::ON_SELL,
            self::ARCHIVED,
        ]);

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isSelling(): bool
    {
        return $this->value === self::ON_SELL;
    }

    public function isArchived(): bool
    {
        return $this->value === self::ARCHIVED;
    }

    /**
     * @param Status $object
     */
    public function isEqualTo(ValueObject $object): bool
    {
        return $this->value === $object->getValue();
    }
}
