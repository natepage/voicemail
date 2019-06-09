<?php
declare(strict_types=1);

namespace App\Services\Google;

use App\Services\Google\Exceptions\InvalidTokenContentException;
use App\Services\Google\Exceptions\UnableToDecodeIdTokenException;
use App\Services\Google\Interfaces\IdTokenDecoderInterface;
use App\Services\Google\Interfaces\PublicKeysRepositoryInterface;
use Firebase\JWT\JWT;

final class IdTokenDecoder implements IdTokenDecoderInterface
{
    /** @var string */
    public const ISS = 'https://accounts.google.com';

    /** @var string */
    private $clientId;

    /** @var \App\Services\Google\Interfaces\PublicKeysRepositoryInterface */
    private $publicKeysRepository;

    /**
     * IdTokenDecoder constructor.
     *
     * @param string $actionsClientId
     * @param \App\Services\Google\Interfaces\PublicKeysRepositoryInterface $publicKeysRepository
     */
    public function __construct(string $actionsClientId, PublicKeysRepositoryInterface $publicKeysRepository)
    {
        $this->clientId = $actionsClientId;
        $this->publicKeysRepository = $publicKeysRepository;
    }

    /**
     * Decode given id token.
     *
     * @param string $idToken
     *
     * @return mixed[]
     */
    public function decode(string $idToken): array
    {
        $publicKeys = $this->publicKeysRepository->get();

        try {
            $decoded = (array)JWT::decode($idToken, $publicKeys['keys'], $publicKeys['algorithms']);
        } catch (\Exception $exception) {
            throw new UnableToDecodeIdTokenException($exception->getMessage(), $exception->getCode(), $exception);
        }

        if (($decoded['iss'] ?? null) !== self::ISS) {
            throw new InvalidTokenContentException(\sprintf('Invalid iss "%s"', $decoded['iss'] ?? null));
        }

        if (($decoded['aud'] ?? null) !== $this->clientId) {
            throw new InvalidTokenContentException(\sprintf('Invalid aud "%s"', $decoded['aud'] ?? null));
        }

        return $decoded;
    }
}
