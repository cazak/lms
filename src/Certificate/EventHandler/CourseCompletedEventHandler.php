<?php

declare(strict_types=1);

namespace App\Certificate\EventHandler;

use DateTimeImmutable;

final readonly class CourseCompletedEventHandler
{
    public function __construct(private CertificateGenerator $generator)
    {
    }

    /**
     * @param CourseCreatedEvent $event
     */
    public function __invoke(Event $event): void
    {
        $command = new CreateCertificateCommand(
            $event->courseId,
            $event->studentId,
        );

        $this->commandBus->dispatch($command);

//        $template = $this->repository->findTemplateByCourseId($event->courseId);
//        $courseData = $this->courseQuery->findById($event->courseId);
//        $studentData = $this->studentQuery->findById($event->studentId);
//
//        $this->generator->generate($template, $courseData, $studentData);
    }
}
