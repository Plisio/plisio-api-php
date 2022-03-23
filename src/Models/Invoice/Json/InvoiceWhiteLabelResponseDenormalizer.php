<?php

/**
 * @noinspection ReturnTypeCanBeDeclaredInspection
 * @noinspection PhpMissingReturnTypeInspection
 */
namespace PlisioPhpSdk\Models\Invoice\Json;

use PlisioPhpSdk\Models\Invoice\InvoiceExtendedResponse;
use PlisioPhpSdk\Models\Invoice\InvoiceWhiteLabelResponse;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class InvoiceWhiteLabelResponseDenormalizer implements DenormalizerInterface
{
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return new InvoiceWhiteLabelResponse(
            $data['status'],
            new InvoiceExtendedResponse(
                $data['data']['amount'],
                $data['data']['pending_amount'],
                $data['data']['wallet_hash'],
                $data['data']['psys_cid'],
                $data['data']['currency'],
                $data['data']['source_currency'],
                $data['data']['source_rate'],
                $data['data']['expected_confirmations'],
                $data['data']['qr_code'],
                $data['data']['verify_hash'],
                $data['data']['invoice_commission'],
                $data['data']['invoice_sum'],
                $data['data']['invoice_total_sum'],
                $data['data']['txn_id'],
                $data['data']['invoice_url']
            )
        );
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === InvoiceWhiteLabelResponse::class;
    }
}
