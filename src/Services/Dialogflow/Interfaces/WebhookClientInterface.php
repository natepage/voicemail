<?php
declare(strict_types=1);

namespace App\Services\Dialogflow\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface WebhookClientInterface
{
    /**
     * Handle dialogflow webhook fulfillment.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request): Response;
}
