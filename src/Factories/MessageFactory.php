<?php
declare(strict_types=1);

namespace App\Factories;

use App\Entity\Message;
use App\Factories\Interfaces\MessageFactoryInterface;

final class MessageFactory implements MessageFactoryInterface
{
    /**
     * Create message for given data.
     *
     * @param mixed[] $data
     *
     * @return \App\Entity\Message
     */
    public function create(array $data): Message
    {
        return (new Message())
            ->setSender($data['sender'])
            ->setBody($data['body']);
    }
}
