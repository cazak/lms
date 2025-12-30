<?php

declare(strict_types=1);

namespace App\Certificate\Command\CreateCertificateTemplate;

use App\Certificate\Command\CertificateTemplate;
use App\Certificate\Command\CourseId;
use App\Certificate\Command\Exception;
use App\Certificate\Command\Id;
use App\Certificate\Command\Style;

final readonly class CreateCertificateTemplateCommandHandler
{
    public function __invoke(CreateCertificateTemplateCommand $command): void
    {
        $courseId = $this->query->findCourseById($command->courseId);

        if ($courseId === null) {
            throw new Exception('Course not found');
        }

        $certificateTemplate = $this->repository->findTemplateByCourse($courseId);
        if ($certificateTemplate !== null) {
            throw new Exception('Certificate template already exists');
        }

        // work with image
        $backgroundImagePath = $this->fileSaver->save($command->backgroundImage);
        // work with image

        $certificateTemplate = new CertificateTemplate(
            Id::generate(),
            new CourseId($courseId),
            Style::from($command->style),
            $backgroundImagePath,
        );

        $this->repository->save($certificateTemplate);
        $this->flusher->flush();
    }
}
