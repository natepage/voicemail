<?php
declare(strict_types=1);

namespace App\Factories\Interfaces;

use App\Entity\User;

interface UserFactoryInterface
{
    /**
     * Create user for given data.
     *
     * @param mixed[] $data
     *
     * @return \App\Entity\User
     */
    public function create(array $data): User;
}
