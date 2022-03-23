<?php

/**
 * @noinspection PhpMissingReturnTypeInspection
 * @noinspection ReturnTypeCanBeDeclaredInspection
 */
namespace PlisioPhpSdk\Models\Fee\Json;

use PlisioPhpSdk\Models\Fee\FeeApiResponse;
use PlisioPhpSdk\Models\Fee\FeeResponse;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class FeeApiResponseDenormalizer implements DenormalizerInterface
{
    use DenormalizerAwareTrait;

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return new FeeApiResponse(
            $data['status'],
            new FeeResponse(
                $data['fee'],
                $data['psys_cid'],
                $data['currency'],
                $data['plan']
            )
        );
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === FeeApiResponse::class;
    }
}
