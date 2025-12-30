<?php

declare(strict_types=1);

namespace App\Course\Entity;

use App\Course\Entity\Module\DTO\LectureDTO;
use App\Course\Entity\Module\Module;
use App\Course\Entity\ValueObject\DifficultyLevel;
use App\Course\Entity\ValueObject\Status;
use DateTimeImmutable;
use DomainException;

/**
 * OneToMany Course->modules
 * ManyToMany Course->gainSkills
 * ManyToOne Course->category
 *
 * @package Course
 */
final class Course
{
    private readonly Id $id;

    private readonly AuthorId $authorId;

    private string $name;

    private ?string $description;

    private ?string $longDescription;

    private ?Avatar $avatar;

    private CategoryId $categoryId;

    private Language $language;

    private DifficultyLevel $difficultyLevel;

    /** @var Collection<int, Module> */
    private Collection $modules;

    private Status $status;

    /** @var Collection<int, GainSkill> */
    private Collection $gainSkills;

    private AccessTime $accessTime;

    /**
     * @var array<int, non-empty-string>
     */
    private array $requirements;

    private int $rating;

    private string $price;

    private readonly DateTimeImmutable $createdAt;

    private DateTimeImmutable $updatedAt;

    public function __construct(
        Id $id,
        AuthorId $authorId,
        CategoryId $categoryId,
        string $name,
        AccessTime $accessTime,
        ?Language $language,
        ?DateTimeImmutable $createdAt = null
    ) {
        $this->id = $id;
        $this->authorId = $authorId;
        $this->categoryId = $categoryId;
        $this->name = $name;
        $this->accessTime = $accessTime;
        $this->language = $language ?? Language::default();
        $this->status = new Status(Status::DRAFT);
        $this->createdAt = $createdAt ?? new DateTimeImmutable();
        $this->updatedAt = $createdAt ?? new DateTimeImmutable();

        $this->gainSkills = new ArrayCollection();
    }

    public function addModule(Module $module): void
    {
        $this->assertCanBeChanged();
        foreach ($this->modules as $existingModule) {
            if ($module->getName() === $existingModule->getName()) {
                throw new DomainException('Module already exists.');
            }
        }

        $this->modules->add($module);
        $this->returnToDraft();
    }

    public function updateModuleName(string $moduleId, string $name): void
    {
        $this->assertCanBeChanged();
        foreach ($this->modules as $existingModule) {
            if ($moduleId === $existingModule->getId()) {
                $existingModule->updateName($name);
                $this->returnToDraft();

                return;
            }
        }

        throw new DomainException(sprintf('Module with this id %s does not exist.', $moduleId));
    }

    public function addLectureToModule(
        string $moduleId,
        LectureDTO $lectureDTO,
    ): void {
        $this->assertCanBeChanged();

        $module = $this->getModule($moduleId);
        $module->addLecture($lectureDTO);
        $this->returnToDraft();
    }

    public function updateLecture(
        string $moduleId,
        string $lectureId,
        LectureDTO $lectureDTO,
    ): void {
        $this->assertCanBeChanged();

        $module = $this->getModule($moduleId);
        $module->updateLecture($lectureId, $lectureDTO);

        $this->returnToDraft();
    }

    public function publish(): void
    {
        if (!$this->canBeChanged()) {
            throw new DomainException('Course on selling or archived');
        }

        $this->status = new Status(Status::PUBLISHED);
        $this->recordEvent(new CoursePublishedEvent($this->getId()));
    }

    public function updateTextInformation(
        string $name,
        ?string $description,
        ?string $longDescription
    ): void {
        $this->assertCanBeChanged();

        $this->name = $name;
        $this->description = $description;
        $this->longDescription = $longDescription;

        $this->returnToDraft();
    }

    /**
     * @param list<int, non-empty-string> $requirements
     */
    public function updateSkillInfo(
        DifficultyLevel $difficultyLevel,
        array $gainSkills,
        array $requirements
    ): void {
        $this->assertCanBeChanged();

        $this->gainSkills->clear();
        foreach ($gainSkills as $gainSkill) {
            if (!$this->gainSkills->contains($gainSkill)) {
                $this->gainSkills->add($gainSkill);
            }
        }

        $this->difficultyLevel = $difficultyLevel;
        $this->requirements = $requirements;
    }

    public function updateRating(int $rating): void
    {
        $this->assertCanBeChanged();

        Assert::greaterOrEqual($rating, 0);
        Assert::smallerOrEqual($rating, 5);

        $this->rating = $rating;
    }

    public function setLanguage(Language $language): void
    {
        $this->language = $language;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    private function returnToDraft(): void
    {
        if (!$this->canBeChanged()) {
            throw new DomainException('Course on selling or archived');
        }

        $this->status = new Status(Status::DRAFT);
    }

    private function assertCanBeChanged(): void
    {
        if (!$this->canBeChanged()) {
            throw new DomainException('Course cannot be changed');
        }
    }

    public function canBeChanged(): bool
    {
        return !$this->status->isSelling() && !$this->status->isArchived();
    }

    private function getModule(string $moduleId): Module
    {
        foreach ($this->modules as $existingModule) {
            if ($moduleId === $existingModule->getId()) {
                return $existingModule;
            }
        }

        throw new DomainException(sprintf('Module with id %s does not exist.', $moduleId));
    }
}
