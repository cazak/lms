<?php

declare(strict_types=1);

namespace App\Schedule\EventHandler;

use App\Schedule\Command\Start\StartScheduleCommand;

#[AsEventListener]
final readonly class StartScheduleEventHandler
{
    public function __construct(
        private CommandBus $commandBus
    ) {
    }

    /**
     * @param PurchaseCreatedEvent $event
     */
    public function __invoke(Event $event): void
    {
        $command = new StartScheduleCommand(
            $event->getCourseId(),
            $event->getStudentId(),
        );
        $this->commandBus->handle($command);
    }
}
