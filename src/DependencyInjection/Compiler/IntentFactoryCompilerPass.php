<?php
declare(strict_types=1);

namespace App\DependencyInjection\Compiler;

use App\Services\Dialogflow\IntentFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class IntentFactoryCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    public function process(ContainerBuilder $container): void
    {
        $intents = $container->findTaggedServiceIds('dialogflow.intent');
        $mapping = [];

        foreach ($intents as $id => $tags) {
            $ref = $container->getReflectionClass($id);
            $intentName = $ref->getMethod('getIntentName')->invoke($ref->newInstanceWithoutConstructor());

            $mapping[$intentName] = $id;
        }

        $factory = $container->findDefinition(IntentFactory::class);
        $factory->setArgument(1, $mapping);
    }
}
