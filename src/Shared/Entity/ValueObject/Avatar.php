<?php

declare(strict_types=1);

namespace App\Shared\Entity\ValueObject;

use Webmozart\Assert\Assert;

final readonly class Avatar implements ValueObject
{
    /**
     * @var non-empty-string
     */
    private string $value;

    public function __construct(string $value)
    {
        Assert::regex($value, '/\\.(jpe?g|png|gif|bmp|webp|avif)$/i', 'Invalid image format.');

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param Avatar $object
     */
    public function isEqualTo(ValueObject $object): bool
    {
        return $this->value === $object->getValue();
    }
}
