<?php

declare(strict_types=1);

namespace App\Schedule\EventHandler;

use App\Schedule\Command\Start\StartScheduleCommand;

#[AsEventListener]
final readonly class CancelScheduleEventHandler
{
    public function __construct(
        private CommandBus $commandBus
    ) {
    }

    /**
     * @param RefundEvent $event
     */
    public function __invoke(Event $event): void
    {
        $command = new CancelScheduleCommand(
//            $event->getCourseId(),
//            $event->getStudentId(),
            $event->getPurchaseId(),
        );
        $this->commandBus->handle($command);
    }
}
