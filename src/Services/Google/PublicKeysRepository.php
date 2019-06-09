<?php
declare(strict_types=1);

namespace App\Services\Google;

use App\Services\Google\Exceptions\InvalidPublicKeyStructureException;
use App\Services\Google\Exceptions\NoPublicKeyFoundException;
use App\Services\Google\Interfaces\PublicKeysRepositoryInterface;
use CoderCat\JWKToPEM\JWKConverter;

final class PublicKeysRepository implements PublicKeysRepositoryInterface
{
    /** @var string */
    private $jwkConverter;

    /** @var string */
    private $url;

    /**
     * PublicKeysRepository constructor.
     *
     * @param string $googlePublicKeysUrl
     * @param null|\CoderCat\JWKToPEM\JWKConverter $jwkConverter
     */
    public function __construct(string $googlePublicKeysUrl, ?JWKConverter $jwkConverter = null)
    {
        $this->url = $googlePublicKeysUrl;
        $this->jwkConverter = $jwkConverter ?? new JWKConverter();
    }

    /**
     * Get google public keys and their algorithms as ['keys' => [], 'algorithms' => []].
     *
     * @return mixed[]
     */
    public function get(): array
    {
        $keys = \json_decode(\file_get_contents($this->url), true);

        if (empty($keys['keys'] ?? []) || empty($keys['keys'][0] ?? [])) {
            throw new NoPublicKeyFoundException(\sprintf('No public key found from "%s"', $this->url));
        }

        $return = ['keys' => [], 'algorithms' => []];

        foreach ($keys['keys'] as $index => $key) {
            if (empty($key['kid'] ?? null)) {
                throw new InvalidPublicKeyStructureException(\sprintf('No kid specified for key[%d]', $index));
            }

            $return['algorithms'][] = $key['alg'];

            try {
                $return['keys'][$key['kid']] = $this->jwkConverter->toPEM($key);
            } catch (\Exception $exception) {
                throw new InvalidPublicKeyStructureException(
                    $exception->getMessage(),
                    $exception->getCode(),
                    $exception
                );
            }
        }

        return $return;
    }
}
