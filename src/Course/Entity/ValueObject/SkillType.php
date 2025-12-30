<?php

declare(strict_types=1);

namespace App\Course\Entity\ValueObject;

use App\Shared\Entity\ValueObject\ValueObject;

final readonly class SkillType implements ValueObject
{
    private const string FRONTEND = 'frontend';

    private const string BACKEND = 'backend';

    private const string DATABASE = 'database';

    private string $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, [
            self::FRONTEND,
            self::BACKEND,
            self::DATABASE,
        ]);

        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->name;
    }

    /**
     * @param SkillType $object
     */
    public function isEqualTo(ValueObject $object): bool
    {
        return $this->name === $object->getValue();
    }
}
