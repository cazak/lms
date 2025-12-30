<?php

declare(strict_types=1);

namespace App\Certificate\Command\UpdateCertificateTemplate;

use App\Certificate\Command\CertificateTemplate;
use App\Certificate\Command\CourseId;
use App\Certificate\Command\Exception;
use App\Certificate\Command\Id;
use App\Certificate\Command\Style;

final readonly class UpdateCertificateTemplateCommandHandler
{
    public function __invoke(UpdateCertificateTemplateCommand $command): void
    {
        $courseId = $this->query->findCourseById($command->courseId);

        if ($courseId === null) {
            throw new Exception('Course not found');
        }

        $certificateTemplate = $this->repository->findTemplateByCourse($courseId);
        if ($certificateTemplate === null) {
            throw new Exception('Certificate template not found');
        }

        // work with image
        $backgroundImagePath = $this->fileSaver->save($command->backgroundImage);
        // work with image

        $certificateTemplate->update(
            Style::from($command->style),
            $backgroundImagePath,
        );

        $this->flusher->flush();
    }
}
