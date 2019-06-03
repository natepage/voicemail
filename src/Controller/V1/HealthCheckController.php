<?php
declare(strict_types=1);

namespace App\Controller\V1;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class HealthCheckController
{
    /**
     * @Route("/ping", name="health_ping")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function ping(): JsonResponse
    {
        return new JsonResponse(['pong']);
    }
}
