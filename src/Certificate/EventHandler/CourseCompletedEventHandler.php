<?php

declare(strict_types=1);

namespace App\Certificate\EventHandler;

use DateTimeImmutable;

final readonly class CourseCompletedEventHandler
{
    public function __construct(private CertificateGenerator $generator)
    {
    }

    public function __invoke($event): void
    {
        $template = $this->repository->findTemplateByCourseId($event->courseId);
        $courseData = $this->courseQuery->findById($event->courseId);
        $studentData = $this->studentQuery->findById($event->studentId);

        $this->generator->generate($template, $courseData, $studentData);
    }
}

class CreateCertificateHandler
{
    public function __construct(private CertificateGenerator $generator)
    {
    }

    public function __invoke($command)
    {
        $certificatePath = $this->generator->generate($command);
    }
}

class CertificateGenerator
{
    public function generate($template, $course, $student): Certificate
    {
        $result = $this->twig->render($this->getPathToCertificateTemplate(), [
            'image' => $template->getImage(),
            'style' => $template->getStyle(),
            'studentName' => $student->getFullName(),
            'courseName' => $course->getName(),
        ]);

        $fileName = $this->fileSaver->generateName();
        $pathToCertificate = $this->fileSaver->save($fileName, $result);

        return new Certificate(
            Id::generate(),
            new StudentId($student->getId()),
            new CourseId($course->getId()),
            $template,
            $this->codeGenerator->generateCertificateCode(),
            $pathToCertificate,
            new DateTimeImmutable(),
        );
    }
}
