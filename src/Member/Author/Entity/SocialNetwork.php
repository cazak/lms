<?php

declare(strict_types=1);

namespace App\Member\Author\Entity;

use App\Member\Author\Entity\ValueObject\Id;

final readonly class SocialNetwork
{
    private Id $id;

    private Author $author;

    private string $name;

    private string $network;

    public function __construct(Author $author, string $name, string $network)
    {
        $this->id = Id::generate();
        $this->author = $author;
        $this->name = $name;
        $this->network= $network;
    }
}
