<?php
declare(strict_types=1);

namespace App\Services\Dialogflow\Intents;

final class SendMessageIntent extends AbstractSignedInIntent
{
    /**
     * Get intent name.
     *
     * @return string
     */
    public function getIntentName(): string
    {
        return 'send_message';
    }

    /**
     * Handle for children intent once user is signed in.
     *
     * @return void
     */
    protected function doHandle(): void
    {
        \dump($this->client->getParameters());

        $this->reply('Sure I will send the message');
    }
}
