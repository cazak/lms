<?php

declare(strict_types=1);

namespace App\Course\Entity\Module\DTO;

use App\Course\Entity\Module\ValueObject\Content;

final readonly class LectureDTO
{
    public function __construct(
        public string $name,
        public Content $content,
        /** @var null|list<QuestionDTO> $questions */
        public ?array $questions = null,
    ) {
    }
}
