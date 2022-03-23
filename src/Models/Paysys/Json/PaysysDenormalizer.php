<?php

/**
 * @noinspection PhpMissingReturnTypeInspection
 * @noinspection ReturnTypeCanBeDeclaredInspection
 */
namespace PlisioPhpSdk\Models\Paysys\Json;

use PlisioPhpSdk\Models\Paysys\Paysys;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class PaysysDenormalizer implements DenormalizerInterface
{
    use DenormalizerAwareTrait;

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return new Paysys(
            $data['name'],
            $data['cid'],
            $data['currency'],
            $data['icon'],
            $data['rate_usd'],
            $data['price_usd'],
            $data['precision'],
            $data['fiat'],
            $data['fiat_rate'],
            $data['min_sum_in'],
            $data['invoice_commission_percentage'],
            $data['hidden'],
            $data['maintenance']
        );
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === Paysys::class;
    }
}
