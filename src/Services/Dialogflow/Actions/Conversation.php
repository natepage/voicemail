<?php
declare(strict_types=1);

namespace App\Services\Dialogflow\Actions;

use Dialogflow\Action\Conversation as BaseConversation;

final class Conversation extends BaseConversation
{
    /**
     * Conversation constructor.
     *
     * @param mixed[] $payload
     */
    public function __construct(array $payload)
    {
        parent::__construct($payload);

        if (isset($payload['user'])) {
            $this->user = new User($payload['user']);
        }
    }

    /**
     * Override parent for type hint.
     *
     * @return null|\App\Services\Dialogflow\Actions\User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }
}
