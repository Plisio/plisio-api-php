<?php

/**
 * @noinspection ReturnTypeCanBeDeclaredInspection
 * @noinspection PhpMissingReturnTypeInspection
 */
namespace PlisioPhpSdk\Models\Balance\Json;

use PlisioPhpSdk\Models\Balance\BalanceResponse;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class BalanceResponseDenormalizer implements DenormalizerInterface
{
    use DenormalizerAwareTrait;

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $denormalizeCall = static function ($data) {
            return new BalanceResponse($data['psys_cid'], $data['balance'], $data['currency']);
        };

        if ($this->isMultiDim($data)) {
            return array_map($denormalizeCall, $data);
        }

        return [$denormalizeCall($data)];
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === BalanceResponse::class;
    }

    private function isMultiDim($data): bool
    {
        $result = array_filter($data, 'is_array');

        return count($result) > 0;
    }
}
