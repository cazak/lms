<?php

declare(strict_types=1);

namespace App\Member\Author\Entity\ValueObject;

use App\Shared\Entity\ValueObject\ValueObject;
use Webmozart\Assert\Assert;

final readonly class Phone implements ValueObject
{
    /**
     * @var non-empty-string
     */
    private string $value;

    public function __construct(string $value)
    {
        Assert::regex($value, '/^\+?\d{1,3}[-.\s]?\d{3}[-.\s]?\d{3}[-.\s]?\d{4}$/', 'Invalid phone number format.');
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param Phone $object
     */
    public function isEqualTo(ValueObject $object): bool
    {
        return $this->value === $object->getValue();
    }
}
