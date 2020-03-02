<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use App\Core\CurrencyCache;

class CacheController
{
    private $cache = null;

    public function __construct(CurrencyCache $cache)
    {
        $this->cache = $cache;
    }

    public function clearCache()
    {
        $this->cache->purgeCache();

        return new JsonResponse([
            'error' => 0,
            'msg' => "OK",
        ]);
    }
}
