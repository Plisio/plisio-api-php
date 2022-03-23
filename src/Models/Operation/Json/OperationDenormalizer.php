<?php

/**
 * @noinspection ReturnTypeCanBeDeclaredInspection
 * @noinspection PhpMissingReturnTypeInspection
 */

namespace PlisioPhpSdk\Models\Operation\Json;

use PlisioPhpSdk\Models\Operation\Operation;
use PlisioPhpSdk\Models\Operation\TransactionItem;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use PlisioPhpSdk\Common\Annotations\DependsOn;

/**
 * @DependsOn(dependencyClass="PlisioPhpSdk\Models\Operation\Json\OperationParamsDenormalizer")
 */
class OperationDenormalizer implements DenormalizerInterface
{
    use DenormalizerAwareTrait;

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return new Operation(
            $data['shop_id'],
            $data['type'],
            $data['status'],
            $data['pending_sum'],
            $data['psys_cid'],
            $data['currency'],
            $data['source_currency'],
            $data['source_rate'],
            $data['fee'],
            $data['wallet_hash'],
            $data['sendmany'],
            count($data['params']) > 0 ? $this->denormalizer->denormalize($data['params'], $type, $format, $context) : null,
            $data['expire_at_utc'],
            $data['created_at_utc'],
            $data['amount'],
            $data['sum'],
            $data['commission'],
            $data['tx_url'],
            $data['tx_id'],
            $data['id'],
            $data['actual_sum'],
            $data['actual_commission'],
            $data['actual_fee'],
            $data['actual_invoice_sum'],
            array_map(
                static function ($data) {
                    return TransactionItem::fromArray($data);
                },
                $data['tx']
            ),
            $data['confirmations'],
            $data['status_code'],
            $data['user_id']
        );
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === Operation::class;
    }
}
