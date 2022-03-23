<?php

/**
 * @noinspection PhpMissingReturnTypeInspection
 * @noinspection ReturnTypeCanBeDeclaredInspection
 */
namespace PlisioPhpSdk\Models\Cryptocurrency\Json;

use PlisioPhpSdk\Models\Cryptocurrency\CryptocurrencyApiResponse;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use PlisioPhpSdk\Common\Annotations\DependsOn;

/**
 * @DependsOn(dependencyClass="PlisioPhpSdk\Models\Paysys\Json\PaysysDenormalizer")
 */
class CryptocurrencyApiResponseDenormalizer implements DenormalizerInterface
{
    use DenormalizerAwareTrait;

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return new CryptocurrencyApiResponse(
            $data['status'],
            array_map(
                function ($data) use ($type, $format, $context) {
                    return $this->denormalizer->denormalize($data, $type, $format, $context);
                },
                $data['data']
            )
        );
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === CryptocurrencyApiResponse::class;
    }
}
