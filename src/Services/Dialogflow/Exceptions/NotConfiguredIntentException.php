<?php
declare(strict_types=1);

namespace App\Services\Dialogflow\Exceptions;

use App\Services\Dialogflow\Interfaces\DialogflowExceptionInterface;

final class NotConfiguredIntentException extends \InvalidArgumentException implements DialogflowExceptionInterface
{
    // No body needed.
}
