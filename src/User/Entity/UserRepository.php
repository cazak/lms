<?php

declare(strict_types=1);

namespace App\User\Entity;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class UserRepository
{
    /**
     * @param EntityRepository<User> $repo
     */
    public function __construct(private EntityManagerInterface $entityManager, private EntityRepository $repo)
    {
    }

    public function hasByEmail(Email $email): bool
    {
        return $this->repo->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->andWhere('u.email = :email')
            ->setParameter(':email', $email->getValue())
            ->getQuery()->getSingleScalarResult() > 0;
    }

    public function getByJoinConfirmationToken(string $token): User
    {
        $user = $this->repo->createQueryBuilder('u')
            ->andWhere('u.token = :token')
            ->setParameter(':token', $token)
            ->getQuery()->getResult();

        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        return $user;
    }

    public function add(User $user): void
    {
        $this->entityManager->persist($user);
    }
}
