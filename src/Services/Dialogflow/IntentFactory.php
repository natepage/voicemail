<?php
declare(strict_types=1);

namespace App\Services\Dialogflow;

use App\Services\Dialogflow\Exceptions\NotConfiguredIntentException;
use App\Services\Dialogflow\Interfaces\IntentFactoryInterface;
use App\Services\Dialogflow\Interfaces\IntentInterface;
use Psr\Container\ContainerInterface;

final class IntentFactory implements IntentFactoryInterface
{
    /** @var \Psr\Container\ContainerInterface */
    private $container;

    /** @var string[] */
    private $intents;

    /**
     * IntentFactory constructor.
     *
     * @param \Psr\Container\ContainerInterface $container
     * @param string[] $intents
     */
    public function __construct(ContainerInterface $container, array $intents)
    {
        $this->container = $container;
        $this->intents = $intents;
    }

    /**
     * Create intent for given name.
     *
     * @param string $intent
     *
     * @return \App\Services\Dialogflow\Interfaces\IntentInterface
     */
    public function create(string $intent): IntentInterface
    {
        if (isset($this->intents[$intent]) && $this->container->has($this->intents[$intent])) {
            return $this->container->get($this->intents[$intent]);
        }

        throw new NotConfiguredIntentException(\sprintf('No intent configured for "%s"', $intent));
    }
}
