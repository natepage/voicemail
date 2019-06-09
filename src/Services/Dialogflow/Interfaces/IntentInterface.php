<?php
declare(strict_types=1);

namespace App\Services\Dialogflow\Interfaces;

use App\Services\Dialogflow\Actions\WebhookClient as BaseWebhookClient;

interface IntentInterface
{
    /**
     * Handle intent fulfillment for given client.
     *
     * @param \App\Services\Dialogflow\Actions\WebhookClient $client
     *
     * @return void
     */
    public function handle(BaseWebhookClient $client): void;
}
