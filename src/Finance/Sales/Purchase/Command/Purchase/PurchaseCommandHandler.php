<?php

declare(strict_types=1);

namespace App\Finance\Sales\Purchase\Command\Purchase;

use App\Finance\Sales\Purchase\Command\Purchase\Component\IsCourseAlreadySchedulingQuery;
use App\Finance\Sales\Purchase\Command\Purchase\Component\IsCourseAlreadySchedulingQueryHandler;
use App\Finance\Sales\Purchase\Entity\Purchase;
use App\Finance\Sales\Command\Purchase\BalanceId;
use App\Finance\Sales\Command\Purchase\FundsNotEnough;
use App\Finance\Sales\Command\Purchase\Id;
use App\Finance\Sales\Command\Purchase\Money;
use App\Finance\Sales\Command\Purchase\Sale;
use App\Finance\Sales\Command\Purchase\Transaction;
use App\Finance\Sales\Command\Purchase\TransactionType;
use App\Finance\Sales\Purchase\Command\Purchase\InsufficentFundsException;
use App\Finance\Sales\Purchase\Command\Purchase\ReserveCommand;
use App\Finance\Sales\Purchase\Command\Purchase\ReserveCommandHandler;
use App\Finance\Sales\Purchase\Command\Purchase\TransactionSource;

/**
 * Покупка курса
 */
final readonly class PurchaseCommandHandler
{
    public function __construct(
//        private int $commissionPercent,
        private ReserveCommandHandler $commandHandler,
        private IsCourseAlreadySchedulingQueryHandler $queryHandler,
    ) {
    }

    public function __invoke(PurchaseCommand $command): void
    {
        $purchase = $this->repository->findLastByCourseAndBuyer($command->courseId, $command->buyerId);
        if ($purchase !== null && $purchase->isActual()) {
            throw new Exception('Course already purchased');
        }

        $query = new IsCourseAlreadySchedulingQuery($command->courseId, $command->buyerId);
        $result = ($this->queryHandler)($query);

        if ($result->isActive()) {
            throw new Exception('Schedule is active');
        }

        $buyerBalance = $this->findBuyerById($command->buyerId);
        $sellerBalance = $this->findSellerById($command->sellerId);
        $courseData = $this->findCourseById($command->courseId);

        if (!$buyerBalance->canBuy($courseData->price)) {
            throw new InsufficentFundsException();
        }

        $this->beginTransaction();

        $amount = Money::from($courseData->amount);

        $purchase = new Purchase(
            Id::next(),
            $amount,
            $courseData->getId(),
            $buyerBalance->getOwnerId(),
            $sellerBalance->getOwnerId(),
        );

//        $transaction = $buyerBalance->decrease(
//            $amount,
//            new TransactionSource($purchase->getId(), TransactionSource::PURCHASE)
//        );

//        $reserve = new Reserve(
//            Id::generate(),
//            $purchase->getId(),
//            $sellerBalance->getOwnerId(),
//            $amount,
//            $this->commissionPercent
//        );

        $command = new ReserveCommand(
            $purchase->getId(),
            $buyerBalance->getOwnerId(),
            $sellerBalance->getOwnerId(),
            $amount
        );
        ($this->commandHandler)($command);
//        $sellerBalance->increase(
//            $amount,
//            new TransactionSource($purchase->getId(), TransactionSource::PURCHASE)
//        );

        $this->purchaseRepository->save($purchase);
//        $this->balanceRepo->save($transaction); // в отдельной команде сделать и вызвать здесь, сам increase надо вызвать в команде, наверное даже в ReserveCommand

        $this->commitTransaction();
    }
}
