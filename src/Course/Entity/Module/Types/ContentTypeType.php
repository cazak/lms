<?php

declare(strict_types=1);

namespace App\Course\Entity\Module\Types;

use App\Course\Entity\Types\ContentType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class ContentTypeType extends Type
{
    public function getName(): string
    {
        return 'content_type';
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ContentType
    {
        return ContentType::from((string) $value);
    }

    /**
     * @param ContentType $value
     */
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        return $value->value;
    }
}
