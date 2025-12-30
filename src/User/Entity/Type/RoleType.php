<?php

declare(strict_types=1);

namespace App\User\Entity\Type;

use App\User\Entity\Role;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

final class RoleType extends GuidType
{
    public const string NAME = 'user_user_role';

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): mixed
    {
        return $value instanceof Role ? $value->getValue() : $value;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?Role
    {
        return !empty($value) ? new Role((string)$value) : null;
    }
}
