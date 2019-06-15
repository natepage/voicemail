<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entity\Message;
use App\Repositories\Interfaces\MessageRepositoryInterface;

final class MessageRepository extends AbstractRepository implements MessageRepositoryInterface
{
    /**
     * Get entity class managed by the repository.
     *
     * @return string
     */
    protected function getEntityClass(): string
    {
        return Message::class;
    }
}
