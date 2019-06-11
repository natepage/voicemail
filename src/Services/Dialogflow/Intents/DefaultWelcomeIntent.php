<?php
declare(strict_types=1);

namespace App\Services\Dialogflow\Intents;

final class DefaultWelcomeIntent extends AbstractSignedInIntent
{
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
     * Handle for children intent once user is signed in.
     *
     * @return void
     */
    protected function doHandle(): void
    {
        $this->reply(\sprintf('Welcome back %s', $this->getUser()->getGivenName()));
    }
}
