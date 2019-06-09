<?php
declare(strict_types=1);

namespace App\Services\Dialogflow;

use App\Services\Dialogflow\Interfaces\IntentFactoryInterface;
use App\Services\Dialogflow\Interfaces\WebhookClientInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Dialogflow\Actions\WebhookClient as BaseWebhookClient;

final class WebhookClient implements WebhookClientInterface
{
    /** @var \App\Services\Dialogflow\Interfaces\IntentFactoryInterface */
    private $intentFactory;

    /** @var \Psr\Log\LoggerInterface */
    private $logger;

    /**
     * WebhookClient constructor.
     *
     * @param \App\Services\Dialogflow\Interfaces\IntentFactoryInterface $intentFactory
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(IntentFactoryInterface $intentFactory, LoggerInterface $logger)
    {
        $this->intentFactory = $intentFactory;
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

        // Make sure request is for Actions on Google
        if ($client->getRequestSource() !== 'google' || $client->getActionConversation() === null) {
            $client->reply('Voicemail supports only Google');

            return $this->respond($client);
        }

        $this->intentFactory->create($client->getIntent())->handle($client);

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
        $this->logger->critical('Received request', $input);

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
        $render = $client->render();

        $this->logger->critical('Returned response', $render);

        return new JsonResponse($render);
    }
}
