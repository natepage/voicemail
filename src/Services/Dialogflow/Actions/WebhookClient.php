<?php
declare(strict_types=1);

namespace App\Services\Dialogflow\Actions;

use Dialogflow\WebhookClient as BaseWebhookClient;

/**
 * Override original to add idToken feature on Google Conversation User.
 */
final class WebhookClient extends BaseWebhookClient
{
    /**
     * Get Actions on Google DialogflowConversation object.
     *
     * @return null|\App\Services\Dialogflow\Actions\Conversation
     */
    public function getActionConversation(): ?Conversation
    {
        if ($this->requestSource !== 'google') {
            return null;
        }

        return new Conversation($this->originalRequest['payload']);
    }
}
