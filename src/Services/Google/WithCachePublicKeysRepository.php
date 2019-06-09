<?php
declare(strict_types=1);

namespace App\Services\Google;

use App\Services\Google\Interfaces\PublicKeysRepositoryInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

final class WithCachePublicKeysRepository implements PublicKeysRepositoryInterface
{
    /** @var \Symfony\Contracts\Cache\CacheInterface */
    private $cache;

    /** @var \App\Services\Google\Interfaces\PublicKeysRepositoryInterface */
    private $decorated;

    /**
     * WithCachePublicKeysRepository constructor.
     *
     * @param \Symfony\Contracts\Cache\CacheInterface $cache
     * @param \App\Services\Google\Interfaces\PublicKeysRepositoryInterface $decorated
     */
    public function __construct(CacheInterface $cache, PublicKeysRepositoryInterface $decorated)
    {
        $this->cache = $cache;
        $this->decorated = $decorated;
    }

    /**
     * Get google public keys and their algorithms as ['keys' => [], 'algorithms' => []].
     *
     * @return mixed[]
     *
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function get(): array
    {
        \var_dump(\get_class($this->cache));

        return $this->cache->get('google_jwks', function (ItemInterface $item): array {
             $item->expiresAfter(3600);

             return $this->decorated->get();
        });
    }
}
