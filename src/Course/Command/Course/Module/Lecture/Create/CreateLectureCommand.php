<?php

declare(strict_types=1);

namespace App\Course\Command\Course\Module\Lecture\Create;

final readonly class CreateLectureCommand
{
    public function __construct(
        public string $name,
        #[Assert\oneOf]
        public string $type,
        public string $content,
        public int $duration,
        #[Assert\Collection]
        public array $questions
    ) {
    }
}
