<?php
declare(strict_types=1);

namespace App\Controller\V1;

use App\Services\Dialogflow\Interfaces\WebhookClientInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DialogflowWebhookController
{
    /**
     * @Route("/webhook", name="dialogflow_webhook")
     *
     * Handle Dialogflow webhook.
     *
     * @param \App\Services\Dialogflow\Interfaces\WebhookClientInterface $webhookClient
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(WebhookClientInterface $webhookClient, Request $request): Response
    {
        return $webhookClient->handle($request);
    }
}
