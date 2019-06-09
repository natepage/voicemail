<?php
declare(strict_types=1);

namespace App\Services\Google\Interfaces;

interface IdTokenDecoderInterface
{
    /**
     * Decode given id token.
     *
     * @param string $idToken
     *
     * @return mixed[]
     */
    public function decode(string $idToken): array;
}
