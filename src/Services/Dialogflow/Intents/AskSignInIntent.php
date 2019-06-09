<?php
declare(strict_types=1);

namespace App\Services\Dialogflow\Intents;

use App\Services\Dialogflow\Interfaces\IntentInterface;
use Dialogflow\Action\Questions\Permission;
use Dialogflow\WebhookClient as BaseWebhookClient;

final class AskSignInIntent implements IntentInterface
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
        $conversation = $client->getActionConversation();

        $conversation->ask(new Permission('Give me your name', ['NAME']));

        $client->reply($conversation);
    }
}
