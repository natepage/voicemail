<?php
declare(strict_types=1);

namespace App\Services\Dialogflow;

use App\Services\Dialogflow\Interfaces\IntentFactoryInterface;
use App\Services\Dialogflow\Interfaces\WebhookClientInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Dialogflow\WebhookClient as BaseWebhookClient;

final class WebhookClient implements WebhookClientInterface
{
    /** @var \App\Services\Dialogflow\Interfaces\IntentFactoryInterface */
    private $intentFactory;

    /**
     * WebhookClient constructor.
     *
     * @param \App\Services\Dialogflow\Interfaces\IntentFactoryInterface $intentFactory
     */
    public function __construct(IntentFactoryInterface $intentFactory)
    {
        $this->intentFactory = $intentFactory;
    }

    /**
     * Handle dialogflow webhook fulfillment.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request): Response
    {
        $client = $this->instantiateBaseClient(\json_decode($request->getContent(), true));
        $intent = $this->intentFactory->create($client->getIntent());

        $intent->handle($client);

        return $this->respond($client);
    }

    /**
     * Instantiate base webhook client.
     *
     * @param mixed[] $input
     *
     * @return \Dialogflow\WebhookClient
     */
    private function instantiateBaseClient(array $input): BaseWebhookClient
    {
        // TODO: handle client failing to parse input
        return new BaseWebhookClient($input);
    }

    /**
     * Return JSON response for given client.
     *
     * @param \Dialogflow\WebhookClient $client
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function respond(BaseWebhookClient $client): Response
    {
        return new JsonResponse($client->render());
    }
}
