<?php

declare(strict_types=1);

namespace App\Member\Author\Entity\ValueObject;

use App\Shared\Entity\ValueObject\ValueObject;
use Webmozart\Assert\Assert;

final readonly class Name implements ValueObject
{
    private string $name;
    private string $lastname;

    public function __construct(string $name, string $lastname)
    {
        Assert::notEmpty($name);
        Assert::notEmpty($lastname);
        $this->name = $name;
        $this->lastname = $lastname;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getFullname(): string
    {
        return $this->name . ' ' . $this->lastname;
    }

    /**
     * @param Name $object
     */
    public function isEqualTo(ValueObject $object): bool
    {
        return $this->getFullname() === $object->getFullname();
    }
}
