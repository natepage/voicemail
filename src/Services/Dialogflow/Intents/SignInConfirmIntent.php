<?php
declare(strict_types=1);

namespace App\Services\Dialogflow\Intents;

use App\Services\Dialogflow\Interfaces\IntentInterface;
use App\Services\Dialogflow\Actions\WebhookClient as BaseWebhookClient;
use App\Services\Google\Interfaces\IdTokenDecoderInterface;

final class SignInConfirmIntent implements IntentInterface
{
    /** @var \App\Services\Google\Interfaces\IdTokenDecoderInterface */
    private $idTokenDecoder;

    /**
     * SignInConfirmIntent constructor.
     *
     * @param \App\Services\Google\Interfaces\IdTokenDecoderInterface $idTokenDecoder
     */
    public function __construct(IdTokenDecoderInterface $idTokenDecoder)
    {
        $this->idTokenDecoder = $idTokenDecoder;
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
        $conversation = $client->getActionConversation();

        $decodedUser = $this->idTokenDecoder->decode($conversation->getUser()->getIdToken());

        $client->reply(\sprintf('Thank you for signing in %s', $decodedUser['name']));
    }
}
