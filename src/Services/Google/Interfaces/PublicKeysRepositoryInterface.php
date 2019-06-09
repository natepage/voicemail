<?php
declare(strict_types=1);

namespace App\Services\Google\Interfaces;

interface PublicKeysRepositoryInterface
{
    /**
     * Get google public keys and their algorithms as ['keys' => [], 'algorithms' => []].
     *
     * @return mixed[]
     */
    public function get(): array;
}
