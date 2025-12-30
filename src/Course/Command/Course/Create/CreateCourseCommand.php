<?php

declare(strict_types=1);

namespace App\Course\Command\Course\Create;

final readonly class CreateCourseCommand
{
    public function __construct(
        public SkillsCommand $skills,
        public string $name,
        public string $authorId,
        public string $categoryId,
        public string $accessTime,
        public string $language,
    ) {
    }
}
