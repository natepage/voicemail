<?php
declare(strict_types=1);

namespace App\Services\Dialogflow\Interfaces;

interface IntentFactoryInterface
{
    /**
     * Create intent for given name.
     *
     * @param string $intent
     *
     * @return \App\Services\Dialogflow\Interfaces\IntentInterface
     */
    public function create(string $intent): IntentInterface;
}
