<?php

declare(strict_types=1);

namespace App\Course\Entity\Module;

use App\Course\Entity\ArrayCollection;
use App\Course\Entity\Collection;
use App\Course\Entity\Course;
use App\Course\Entity\Module\DTO\LectureDTO;
use App\Course\Entity\Uuid;
use DomainException;

/**
 * @internal
 */
final class Module
{
    private readonly string $id;

    private readonly Course $course;

    private string $name;

    /** @var Collection<int, Lecture> */
    private Collection $lectures;

    public function __construct(Course $course, string $name)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->course = $course;
        $this->name = $name;
        $this->lectures = new ArrayCollection();
    }

    public function updateName(string $name): void
    {
        $this->name = $name;
    }

    public function addLecture(LectureDTO $lectureDTO): void
    {
        foreach ($this->lectures as $existingLecture) {
            if ($lectureDTO->name === $existingLecture->getName()) {
                throw new DomainException(sprintf('Lecture with name %s already exists.', $lectureDTO->name));
            }
        }

        $lecture = new Lecture($this, $lectureDTO);
        $this->lectures->add($lecture);
    }

    public function updateLecture(string $lectureId, LectureDTO $lectureDTO): void
    {
        $lecture = $this->getLecture($lectureId);

        $lecture->update($lectureDTO->name, $lectureDTO->content);
        $lecture->updateQuestions($lectureDTO->questions);
    }

    public function getLecture(string $id): Lecture
    {
        foreach ($this->lectures as $lecture) {
            if ($lecture->getId() === $id) {
                return $lecture;
            }
        }

        throw new DomainException(sprintf('Lecture with ID %s not found.', $id));
    }
}
