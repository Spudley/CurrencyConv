<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use App\Core\CurrencyCache;

class DefaultController
{
    public function default()
    {
        return new JsonResponse([
            'error' => 1,
            'msg' => "invalid request",
        ]);
    }
}
