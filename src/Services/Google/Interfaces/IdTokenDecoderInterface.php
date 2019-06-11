<?php
declare(strict_types=1);

namespace App\Services\Google\Interfaces;

use App\Services\Google\GoogleUser;

interface IdTokenDecoderInterface
{
    /**
     * Decode given id token.
     *
     * @param string $idToken
     *
     * @return \App\Services\Google\GoogleUser
     */
    public function decode(string $idToken): GoogleUser;
}
