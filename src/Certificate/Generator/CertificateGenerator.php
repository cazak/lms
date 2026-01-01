<?php

declare(strict_types=1);

namespace App\Certificate\Generator;

final readonly class CertificateGenerator
{
    public function generate($template, $course, $student): string
    {
        $result = $this->twig->render($this->getPathToCertificateTemplate(), [
            'image' => $template->getImage(),
            'style' => $template->getStyle(),
            'studentName' => $student->getFullName(),
            'courseName' => $course->getName(),
        ]);

        $fileName = $this->fileSaver->generateName();
        $pathToCertificate = $this->fileSaver->save($fileName, $result);

        return $pathToCertificate;

//        return new Certificate(
//            Id::generate(),
//            new StudentId($student->getId()),
//            new CourseId($course->getId()),
//            $template,
//            $this->codeGenerator->generateCertificateCode(),
//            $pathToCertificate,
//            new DateTimeImmutable(),
//        );
    }
}
