<?php

/**
 * @noinspection PhpMissingReturnTypeInspection
 * @noinspection ReturnTypeCanBeDeclaredInspection
 */
namespace PlisioPhpSdk\Models\Fee\Json;

use PlisioPhpSdk\Models\Fee\FeePlanApiResponse;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use PlisioPhpSdk\Common\Annotations\DependsOn;

/**
 * @DependsOn(dependencyClass="PlisioPhpSdk\Models\Fee\Json\FeePlanItemDenormalizer")
 */
class FeePlanApiResponseDenormalizer implements DenormalizerInterface
{
    use DenormalizerAwareTrait;

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return new FeePlanApiResponse(
            $data['status'],
            $this->denormalizer->denormalize($data['data'], $type, $format, $context)
        );
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === FeePlanApiResponse::class;
    }
}
