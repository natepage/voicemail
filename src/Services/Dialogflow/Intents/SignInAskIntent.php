<?php
declare(strict_types=1);

namespace App\Services\Dialogflow\Intents;

use App\Services\Dialogflow\Actions\Questions\SignIn;
use App\Services\Dialogflow\Interfaces\IntentInterface;
use App\Services\Dialogflow\Actions\WebhookClient as BaseWebhookClient;

final class SignInAskIntent implements IntentInterface
{
    /**
     * Handle intent fulfillment for given client.
     *
     * @param \App\Services\Dialogflow\Actions\WebhookClient $client
     *
     * @return void
     */
    public function handle(BaseWebhookClient $client): void
    {
        $conversation = $client->getActionConversation();

        $conversation->ask(new SignIn('Sign in!'));

        $client->reply($conversation);
    }
}
