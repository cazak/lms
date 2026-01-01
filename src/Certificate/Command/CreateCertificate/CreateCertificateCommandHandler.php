<?php

declare(strict_types=1);

namespace App\Certificate\Command\CreateCertificate;

final readonly class CreateCertificateCommandHandler
{
    public function __construct(private CertificateGenerator $generator)
    {
    }

    public function __invoke(CreateCertificateCommand $command): void
    {
        $certificateTemplate = $this->repository->findTemplateByCourseId($command->courseId);
        $courseData = $this->courseQuery->findById($command->courseId);
        $studentData = $this->studentQuery->findById($command->studentId);

        $pathToCertificate = $this->generator->generate($certificateTemplate, $courseData, $studentData);

        $certificate = new Certificate(
            Id::generate(),
            new StudentId($command->studentId),
            new CourseId($command->courseId),
            $certificateTemplate,
            $pathToCertificate,
            $this->codeGenerator->generateCertificateCode(),
            new DateTimeImmutable(),
        );

        $this->repository->save($certificate);
        $this->flusher->flush();
    }
}
