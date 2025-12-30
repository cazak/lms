<?php

declare(strict_types=1);

namespace App\Member\Author\Entity\ValueObject;

use App\Shared\Entity\ValueObject\ValueObject;
use Webmozart\Assert\Assert;

final readonly class Email implements ValueObject
{
    /**
     * @var non-empty-string
     */
    private string $value;

    public function __construct(string $value)
    {
        Assert::email($value);
        $this->value = mb_strtolower($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param Email $object
     */
    public function isEqualTo(ValueObject $object): bool
    {
        return $this->value === $object->getValue();
    }
}
