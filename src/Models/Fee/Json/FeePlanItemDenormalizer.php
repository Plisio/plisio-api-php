<?php

/**
 * @noinspection PhpMissingReturnTypeInspection
 * @noinspection ReturnTypeCanBeDeclaredInspection
 */
namespace PlisioPhpSdk\Models\Fee\Json;

use PlisioPhpSdk\Common\Enum\FeePlans;
use PlisioPhpSdk\Models\Fee\FeePlanItem;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class FeePlanItemDenormalizer implements DenormalizerInterface
{
    use DenormalizerAwareTrait;

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $feePlanItems = [];
        foreach ($data as $key => $item) {
            if (null !== $item && in_array($key, FeePlans::asArray(), true)) {
                $feePlanItems[$key] = FeePlanItem::fromArray($item);
            }
        }

        return $feePlanItems;
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === FeePlanItem::class;
    }
}
