<?php

declare(strict_types=1);

namespace App\Course\Entity\Module\DTO;

final readonly class QuestionDTO
{
    public function __construct(
        public string $name,
        public string $answer,
        /** @var array<int, non-empty-string> */
        public array $choices,
    ) {
    }
}
