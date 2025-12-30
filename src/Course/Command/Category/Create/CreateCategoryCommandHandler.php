<?php

declare(strict_types=1);

namespace App\Course\Command\Category\Create;

use App\Course\Entity\Category;

final readonly class CreateCategoryCommandHandler
{
    public function __invoke(CreateCategoryCommand $command): void
    {
        $category = new Category();
    }
}
