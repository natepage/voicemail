<?php
declare(strict_types=1);

namespace App\Factories\Interfaces;

use App\Entity\Message;

interface MessageFactoryInterface
{
    /**
     * Create message for given data.
     *
     * @param mixed[] $data
     *
     * @return \App\Entity\Message
     */
    public function create(array $data): Message;
}
