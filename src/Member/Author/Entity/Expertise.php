<?php

declare(strict_types=1);

namespace App\Member\Author\Entity;

use App\Member\Author\Entity\ValueObject\Avatar;
use App\Member\Author\Entity\ValueObject\Id;

final readonly class Expertise
{
    private Id $id;

    private string $name;

    private Avatar $avatar;

    public function __construct(string $name, Avatar $avatar)
    {
        $this->id = Id::generate();
        $this->name = $name;
        $this->avatar = $avatar;
    }
}
