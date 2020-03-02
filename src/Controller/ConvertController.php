<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use App\Core\Converter;
use App\Exceptions\ConverterException;

class ConvertController
{
    private $converter = null;

    public function __construct(Converter $converter)
    {
        $this->converter = $converter;
    }

    public function convert(int $units, string $fromCurr, string $toCurr)
    {
        try {
            $output = $this->converter->convert($units, $fromCurr, $toCurr);
        } catch (ConverterException $e) {
            $output = [
                'error' => 1,
                'msg' => $e->getMessage()
            ];
        }

        return new JsonResponse($output);
    }
}
