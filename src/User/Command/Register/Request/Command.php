<?php

declare(strict_types=1);

namespace App\User\Command\Register\Request;
final readonly class Command
{
    public function __construct(
        public string $email,
        public string $password,
    ) {
    }
}
