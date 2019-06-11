<?php
declare(strict_types=1);

namespace App\Services\Dialogflow\Intents;

use App\Services\Dialogflow\Actions\Questions\SignIn;
use App\Services\Dialogflow\Actions\WebhookClient as BaseWebhookClient;
use App\Services\Dialogflow\Interfaces\IntentInterface;
use App\Services\Google\GoogleUser;
use App\Services\Google\Interfaces\IdTokenDecoderInterface;
use Psr\Log\LoggerInterface;

abstract class AbstractSignedInIntent implements IntentInterface
{
    /** @var \App\Services\Dialogflow\Actions\WebhookClient */
    protected $client;

    /** @var \App\Services\Dialogflow\Actions\Conversation */
    protected $conv;

    /** @var \Psr\Log\LoggerInterface */
    protected $logger;

    /** @var \App\Services\Google\Interfaces\IdTokenDecoderInterface */
    private $idTokenDecoder;

    /**
     * Handle intent fulfillment for given client.
     *
     * @param \App\Services\Dialogflow\Actions\WebhookClient $client
     *
     * @return void
     */
    public function handle(BaseWebhookClient $client): void
    {
        $this->client = $client;
        $this->conv = $client->getActionConversation();

        // If user not signed in, ask to sign in
        if ($this->isUserSignedIn() === false) {
            $this->reply($this->conv->add(new SignIn()));

            return;
        }

        // Otherwise let child handle
        $this->doHandle();
    }

    /**
     * @required
     *
     * Set id token decoder.
     *
     * @param \App\Services\Google\Interfaces\IdTokenDecoderInterface $idTokenDecoder
     *
     * @return void
     */
    public function setIdTokenDecoder(IdTokenDecoderInterface $idTokenDecoder): void
    {
        $this->idTokenDecoder = $idTokenDecoder;
    }

    /**
     * @required
     *
     * Set logger.
     *
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return void
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * Handle for children intent once user is signed in.
     *
     * @return void
     */
    abstract protected function doHandle(): void;

    /**
     * Get user for given conversation.
     *
     * @return \App\Services\Google\GoogleUser
     */
    protected function getUser(): GoogleUser
    {
        $convUser = $this->conv->getUser();
        $googleUser = $this->idTokenDecoder->decode($convUser->getIdToken());
        $data = ['google_id' => $convUser->getId(), 'locale' => $convUser->getLocale()];

        return new GoogleUser($googleUser->toArray() + $data);
    }

    /**
     * Check if user is signed in.
     *
     * @return bool
     */
    protected function isUserSignedIn(): bool
    {
        if ($this->conv->getUser() === null) {
            return false;
        }

        return $this->conv->getUser()->getIdToken() !== null;
    }

    /**
     * Reply given message.
     *
     * @param string|\Dialogflow\RichMessage\RichMessage|\Dialogflow\Action\Conversation $message
     *
     * @return void
     */
    protected function reply($message): void
    {
        $this->client->reply($message);
    }
}
