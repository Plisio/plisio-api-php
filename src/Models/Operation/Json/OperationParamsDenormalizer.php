<?php

/**
 * @noinspection ReturnTypeCanBeDeclaredInspection
 * @noinspection PhpMissingReturnTypeInspection
 */
namespace PlisioPhpSdk\Models\Operation\Json;

use PlisioPhpSdk\Models\Operation\OperationParams;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use PlisioPhpSdk\Common\Annotations\DependsOn;

/**
 * @DependsOn(dependencyClass="PlisioPhpSdk\Models\Fee\Json\FeeParamsDenormalizer")
 */
class OperationParamsDenormalizer implements DenormalizerInterface
{
    use DenormalizerAwareTrait;

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return new OperationParams(
            $this->denormalizer->denormalize($data['fee'], $type, $format, $context),
            $data['order_number'],
            $data['order_name'],
            $data['description'],
            $data['source_amount'],
            $data['source_currency'],
            $data['value'],
            $data['avatar'],
            $data['store'],
            $data['currency'],
            $data['psys_cid'],
            $data['amount'],
            $data['source_rate']
        );
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === OperationParams::class;
    }
}
