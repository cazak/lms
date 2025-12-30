<?php

declare(strict_types=1);

namespace App\User\Entity\Type;

use App\User\Entity\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

final class EmailType extends GuidType
{
    public const string NAME = 'user_user_email';

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): mixed
    {
        return $value instanceof Email ? $value->getValue() : $value;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?Email
    {
        return !empty($value) ? new Email((string)$value) : null;
    }
}
