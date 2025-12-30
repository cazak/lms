<?php

declare(strict_types=1);

namespace App\Course\Entity\Module\ValueObject;

use App\Shared\Entity\ValueObject\ValueObject;
use InvalidArgumentException;

final readonly class Content implements ValueObject
{
    private ContentType $type;

    private string $content;

    private int $duration; // Секунды

    public function __construct(
        ContentType $type,
        string $content,
        int $duration
    ) {
        if ($type->isText()) {
            if (str_contains($content, '.mp4')) { // .mov, .avi, .mkv
                throw new InvalidArgumentException('Text content cannot contain video extensions');
            }
        } else {
            if (str_contains($content, '.txt')) { // .pdf, .md, .doc, .docx, .odt
                throw new InvalidArgumentException('Video content cannot contain text extensions');
            }
        }

        $this->type = $type;
        $this->content = $content;
        $this->duration = $duration;
    }

    public function getType(): ContentType
    {
        return $this->type;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param Content $object
     */
    public function isEqualTo(ValueObject $object): bool
    {
        return $this->content === $object->getContent() &&
            $this->duration === $object->getDuration() &&
            $this->type === $object->getType();
    }
}
