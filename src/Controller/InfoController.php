<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class InfoController
{
    public function info()
    {
        return new JsonResponse([
            'error' => 0,
            'msg' => 'API written by Simon Champion',
        ]);
    }
}
