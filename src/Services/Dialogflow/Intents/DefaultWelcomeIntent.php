<?php
declare(strict_types=1);

namespace App\Services\Dialogflow\Intents;

use App\Services\Dialogflow\Actions\Questions\SignIn;
use App\Services\Dialogflow\Actions\WebhookClient as BaseWebhookClient;
use App\Services\Dialogflow\Interfaces\IntentInterface;
use App\Services\Dialogflow\Traits\IntentTrait;

final class DefaultWelcomeIntent implements IntentInterface
{
    use IntentTrait;

    /**
     * Get intent name.
     *
     * @return string
     */
    public function getIntentName(): string
    {
        return 'default_welcome';
    }

    /**
     * Handle intent fulfillment for given client.
     *
     * @param \App\Services\Dialogflow\Actions\WebhookClient $client
     *
     * @return void
     */
    public function handle(BaseWebhookClient $client): void
    {
        $conv = $client->getActionConversation();

        // If user not signed in, ask to sign in
        if ($this->isUserSignedIn($conv) === false) {
            $client->reply($conv->add(new SignIn()));

            return;
        }

        $user = $this->getUser($conv);

        $client->reply(\sprintf('Welcome back %s', $user['given_name'] ?? $user['name'] ?? null));
    }
}
