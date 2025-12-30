<?php

declare(strict_types=1);

namespace App\Course\Command\Course\Create;

final readonly class SkillsCommand
{
    public function __construct(
        public string $difficultyLevel,
        public array $gainSkillIds,
        /** @var list<int, non-empty-string> */
        public array $requirements
    ) {
    }
}
