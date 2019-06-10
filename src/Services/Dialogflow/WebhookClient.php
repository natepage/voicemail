<?php
declare(strict_types=1);

namespace App\Services\Dialogflow;

use App\Services\Dialogflow\Actions\WebhookClient as BaseWebhookClient;
use App\Services\Dialogflow\Interfaces\IntentFactoryInterface;
use App\Services\Dialogflow\Interfaces\WebhookClientInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        try {
            $client = $this->instantiateBaseClient(\json_decode($request->getContent(), true));
        } catch (\Exception $exception) {
            $this->logger->error(\sprintf(
                '[Dialogflow] Unable to instantiate base webhook client: %s',
                $exception->getMessage()
            ));

            return $this->fallback('Sorry but I couldn\'t understand your request');
        }

        // Make sure request is for Actions on Google
        if ($client->getRequestSource() !== 'google' || $client->getActionConversation() === null) {
            $client->reply('Voicemail supports only Google');

            return $this->respond($client->render());
        }

        try {
            $this->intentFactory->create($client->getIntent())->handle($client);
        } catch (\Exception $exception) {
            $this->logger->error(\sprintf('[Dialogflow] Unable to handle intent: %s', $exception->getMessage()));
            $client->reply('Sorry but I couldn\'t understand your request');
        }

        return $this->respond($client->render());
    }

    /**
     * Return fallback response when base webhook client not instantiated.
     *
     * @param string $message
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function fallback(string $message): Response
    {
        $fallback = '{
            "fulfillmentMessages": [
                {
                    "platform": "ACTIONS_ON_GOOGLE",
                    "simpleResponses": {
                        "simpleResponses": [
                            {
                                "textToSpeech": "%s",
                                "displayText": "%s"
                            }
                        ]
                    }
                }
            ],
            "outputContexts": []
        }';

        return $this->respond(\json_decode(\sprintf($fallback, $message, $message), true));
    }

    /**
     * Instantiate base webhook client.
     *
     * @param mixed[] $input
     *
     * @return \App\Services\Dialogflow\Actions\WebhookClient
     */
    private function instantiateBaseClient(array $input): BaseWebhookClient
    {
        return new BaseWebhookClient($input);
    }

    /**
     * Return JSON response for given data.
     *
     * @param mixed[] $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function respond(array $data): Response
    {
        return new JsonResponse($data);
    }
}
