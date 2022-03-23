<?php

/**
 * @noinspection ReturnTypeCanBeDeclaredInspection
 * @noinspection PhpMissingReturnTypeInspection
 */
namespace PlisioPhpSdk\Models\Balance\Json;

use PlisioPhpSdk\Models\Balance\BalanceApiResponse;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use PlisioPhpSdk\Common\Annotations\DependsOn;

/**
 * @DependsOn(dependencyClass="PlisioPhpSdk\Models\Balance\Json\BalanceResponseDenormalizer")
 */
class BalanceApiResponseDenormalizer implements DenormalizerInterface
{
    use DenormalizerAwareTrait;

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return new BalanceApiResponse(
            $data['status'],
            $this->denormalizer->denormalize($data['data'], $type, $format, $context)
        );
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === BalanceApiResponse::class;
    }
}
