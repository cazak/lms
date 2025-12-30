<?php

declare(strict_types=1);

namespace App\Member\Author\Command\Create;

use App\Member\Author\Entity\ValueObject\WorkingTime;

final readonly class CreateAuthorCommandHandler
{
    public function __construct(
        private Flusher $flusher,
        private AuthorRepository $authorRepository,

    ) {
    }

    public function __invoke(CreateAuthorCommand $command): void
    {
        $author = new Author(
            Id::generate(),
            new Name($command->firstName, $command->lastName),
            new Email($command->email),
            new Phone($command->phone),
        );

        $author->setStartedYearOfTeaching($command->startedYearOfTeaching);
        if ($command->workingTime) {
            $author->setWorkingTime(new WorkingTime(
                $command->workingDays,
                $command->startWorkingTime,
                $command->endWorkingTime,
            ));
        }

        $this->authorRepository->save($author);
        $this->flusher->flush();
    }
}
