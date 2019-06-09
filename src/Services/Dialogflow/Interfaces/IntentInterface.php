<?php
declare(strict_types=1);

namespace App\Services\Dialogflow\Interfaces;

use Dialogflow\WebhookClient as BaseWebhookClient;

interface IntentInterface
{
    /**
     * Handle intent fulfillment for given client.
     *
     * @param \Dialogflow\WebhookClient $client
     *
     * @return void
     */
    public function handle(BaseWebhookClient $client): void;
}
