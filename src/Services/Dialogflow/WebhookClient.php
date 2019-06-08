<?php
declare(strict_types=1);

namespace App\Services\Dialogflow;

use App\Services\Dialogflow\Interfaces\WebhookClientInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Dialogflow\WebhookClient as BaseWebhookClient;

final class WebhookClient implements WebhookClientInterface
{
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

        $client->reply('Thank you for requesting this webhook');

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
