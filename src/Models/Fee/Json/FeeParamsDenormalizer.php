<?php

/**
 * @noinspection PhpMissingReturnTypeInspection
 * @noinspection ReturnTypeCanBeDeclaredInspection
 */
namespace PlisioPhpSdk\Models\Fee\Json;

use PlisioPhpSdk\Models\Fee\FeeParams;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class FeeParamsDenormalizer implements DenormalizerInterface
{
    use DenormalizerAwareTrait;

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return new FeeParams($data['conf_target'], $data['plan'], $data['value']);
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === FeeParams::class;
    }
}
