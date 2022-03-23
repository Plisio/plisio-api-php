<?php

/**
 * @noinspection PhpMissingReturnTypeInspection
 * @noinspection ReturnTypeCanBeDeclaredInspection
 */
namespace PlisioPhpSdk\Models\Commission\Json;

use PlisioPhpSdk\Models\Commission\CommissionApiResponse;
use PlisioPhpSdk\Models\Commission\CommissionResponse;
use PlisioPhpSdk\Models\Fee\FeePlanCustomItem;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use PlisioPhpSdk\Common\Annotations\DependsOn;

/**
 * @DependsOn(dependencyClass="PlisioPhpSdk\Models\Fee\Json\FeePlanItemDenormalizer")
 */
class CommissionApiResponseDenormalizer implements DenormalizerInterface
{
    use DenormalizerAwareTrait;

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return new CommissionApiResponse(
            $data['status'],
            new CommissionResponse(
                $data['data']['commission'],
                $data['data']['fee'],
                $data['data']['plan'],
                $data['data']['useWallet'],
                $data['data']['useWalletBalance'],
                $this->denormalizer->denormalize($data['data']['plans'], $type, $format, $context),
                FeePlanCustomItem::fromArray($data['data']['custom'])
            )
        );
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === CommissionApiResponse::class;
    }
}
