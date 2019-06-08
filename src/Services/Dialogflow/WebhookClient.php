<?php
declare(strict_types=1);

namespace App\Services\Dialogflow;

use App\Services\Dialogflow\Interfaces\WebhookClientInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Dialogflow\WebhookClient as BaseWebhookClient;

final class WebhookClient implements WebhookClientInterface
{
    /** @var \Psr\Log\LoggerInterface */
    private $logger;

    /**
     * WebhookClient constructor.
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
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
        $this->logger->critical('Received data from Dialogflow', $input);

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
