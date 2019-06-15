<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entity\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

final class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * Find one user by email.
     *
     * @param string $email
     *
     * @return null|\App\Entity\User
     */
    public function findOneByEmail(string $email): ?User
    {
        return $this->repository->findOneBy(['email' => $email]);;
    }

    /**
     * Get entity class managed by the repository.
     *
     * @return string
     */
    protected function getEntityClass(): string
    {
        return User::class;
    }
}
