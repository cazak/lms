<?php

declare(strict_types=1);

namespace App\Finance\Sales\Refund\Command\Refund;

final readonly class RefundCommandHandler
{
    public function __construct(
        private CancelReserveCommandHandler $cancelReserveCommandHandler
    ) {
    }

    public function __invoke(RefundCommand $command): void
    {
//        $reserveData = $this->findReserveByUserAndStatusAndCourse($command->reserveId);
        $reserveData = $this->findReserveByUserAndStatusAndCourse($command->courseId, $command->buyerId);
//        $buyerId = $command->buyerId;
//        $authorId = $command->authorId;

        if (!$reserveData) {
            throw new NotReserveFound();
        }

        $this->beginTransaction();
        $refund = new Refund(
            Id::generate(),
            new CourseId($command->courseId),
            new BuyerId($reserveData->buyerId),
            new AuthorId($reserveData->authorId),
            new ReserveId($reserveData->id),
        );

        $command = new CancelReserveCommand($reserveData->id, $refund->getId());
        ($this->cancelReserveCommandHandler)($command);

        $this->repository->save($refund);
        $this->flusher->flush();

        $this->commitTransaction();
    }
}
