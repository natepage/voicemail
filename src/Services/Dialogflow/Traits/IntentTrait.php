<?php
declare(strict_types=1);

namespace App\Services\Dialogflow\Traits;

use App\Services\Dialogflow\Actions\Conversation;
use App\Services\Google\GoogleUser;
use App\Services\Google\Interfaces\IdTokenDecoderInterface;

trait IntentTrait
{
    /** @var \App\Services\Google\Interfaces\IdTokenDecoderInterface */
    private $idTokenDecoder;

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
     * Get user for given conversation.
     *
     * @param \App\Services\Dialogflow\Actions\Conversation $conv
     *
     * @return \App\Services\Google\GoogleUser
     */
    private function getUser(Conversation $conv): GoogleUser
    {
        return $this->idTokenDecoder->decode($conv->getUser()->getIdToken());
    }

    /**
     * Check if user is signed in.
     *
     * @param \App\Services\Dialogflow\Actions\Conversation $conv
     *
     * @return bool
     */
    private function isUserSignedIn(Conversation $conv): bool
    {
        if ($conv->getUser() === null) {
            return false;
        }

        return $conv->getUser()->getIdToken() !== null;
    }
}
