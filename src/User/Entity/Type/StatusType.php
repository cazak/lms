<?php

declare(strict_types=1);

namespace App\User\Entity\Type;

use App\User\Entity\Status;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

final class StatusType extends GuidType
{
    public const string NAME = 'user_user_status';

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): mixed
    {
        return $value instanceof Status ? $value->getValue() : $value;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?Status
    {
        return !empty($value) ? new Status((string)$value) : null;
    }
}
