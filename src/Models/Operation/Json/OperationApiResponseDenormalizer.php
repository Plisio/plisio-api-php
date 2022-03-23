<?php

/** @noinspection PhpMissingReturnTypeInspection */
/** @noinspection ReturnTypeCanBeDeclaredInspection */

namespace PlisioPhpSdk\Models\Operation\Json;

use PlisioPhpSdk\Models\Operation\OperationApiResponse;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use PlisioPhpSdk\Common\Annotations\DependsOn;

/**
 * @DependsOn(dependencyClass="PlisioPhpSdk\Models\Operation\Json\OperationDenormalizer")
 */
class OperationApiResponseDenormalizer implements DenormalizerInterface
{
    use DenormalizerAwareTrait;

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return new OperationApiResponse(
            $data['status'],
            $this->denormalizer->denormalize($data['data'], $type, $format, $context)
        );
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === OperationApiResponse::class;
    }
}
