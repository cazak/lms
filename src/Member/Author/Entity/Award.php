<?php

declare(strict_types=1);

namespace App\Member\Author\Entity;

use App\Member\Author\Entity\ValueObject\ExperiencePeriod;
use App\Member\Author\Entity\ValueObject\Id;

final readonly class Award
{
    private const string OLYMPIAD = 'olympiad';
    private const string GRANT = 'grant';
    private const string CERTIFICATE = 'certificate';

    private Id $id;

    private int $year;

    private string $title;

    private string $organization;

    private string $type;

    public function __construct(int $year, string $title, string $organization, string $type)
    {
        Assert::oneOf($type, [
            self::OLYMPIAD,
            self::GRANT,
            self::CERTIFICATE
        ]);

        $this->id = Id::generate();
        $this->year = $year;
        $this->title = $title;
        $this->organization = $organization;
        $this->type = $type;
    }
}
