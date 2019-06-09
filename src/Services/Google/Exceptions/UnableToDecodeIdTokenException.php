<?php
declare(strict_types=1);

namespace App\Services\Google\Exceptions;

use App\Services\Google\Interfaces\GoogleExceptionInterface;

final class UnableToDecodeIdTokenException extends \RuntimeException implements GoogleExceptionInterface
{
    // No body needed.
}
