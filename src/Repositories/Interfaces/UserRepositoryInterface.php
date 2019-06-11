<?php
declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Entity\User;

interface UserRepositoryInterface extends AppRepositoryInterface
{
    /**
     * Find one user by email.
     *
     * @param string $email
     *
     * @return null|\App\Entity\User
     */
    public function findOneByEmail(string $email): ?User;
}
