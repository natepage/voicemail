<?php
declare(strict_types=1);

namespace App\Services\Dialogflow\Intents;

use App\Services\Dialogflow\Interfaces\IntentInterface;
use Dialogflow\WebhookClient as BaseWebhookClient;

final class PeterWeirdoIntent implements IntentInterface
{
    /**
     * Handle intent fulfillment for given client.
     *
     * @param \Dialogflow\WebhookClient $client
     *
     * @return void
     */
    public function handle(BaseWebhookClient $client): void
    {
        $client->reply('Yes Peter is a weirdo!');
    }
}