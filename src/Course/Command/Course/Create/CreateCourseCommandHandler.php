<?php

declare(strict_types=1);

namespace App\Course\Command\Course\Create;

use App\Course\Entity\GainSkill;

final readonly class CreateCourseCommandHandler
{
    public function __invoke(CreateCourseCommand $command): void
    {
        $course = new Course(
            Id::generate(),
            new AuthorId($command->authorId),
            new CategoryId($command->categoryId),
            $command->name,
            new AccessTime($command->accessTime),
            $command->language ? new Language($command->language) : Language::default(),
        );

        if ($command->skills) {
            $gainSkills = $this->gainSkillsRepository->findByIds($command->skills->gainSkillIds);

            $course->updateSkillInfo(
                DifficultyLevel::fromString($command->skills->difficultyLevel),
                $gainSkills,
                $command->skills->requirements,
            );
        }

        $this->repository->add($course);
        $this->flusher->flush();
    }
}
