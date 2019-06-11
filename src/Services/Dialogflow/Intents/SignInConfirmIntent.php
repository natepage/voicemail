<?php
declare(strict_types=1);

namespace App\Services\Dialogflow\Intents;

use App\Services\Dialogflow\Actions\WebhookClient as BaseWebhookClient;
use App\Services\Dialogflow\Interfaces\IntentInterface;
use App\Services\Dialogflow\Traits\IntentTrait;

final class SignInConfirmIntent implements IntentInterface
{
    use IntentTrait;

    /**
     * Get intent name.
     *
     * @return string
     */
    public function getIntentName(): string
    {
        return 'sign_in_confirm';
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

        if ($this->isUserSignedIn($conv) === false) {
            $client->reply('Hmm... I couldn\'t identify you, really sorry about that. Please try to come back later');

            return;
        }

        $user = $this->getUser($conv);

        $client->reply(\sprintf(
            'Hey %s! Thank you, I\'m glad to count you as one of my members',
            $user->getGivenName()
        ));
    }
}
