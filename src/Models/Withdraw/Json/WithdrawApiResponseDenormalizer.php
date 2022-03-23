<?php

/**
 * @noinspection PhpMissingReturnTypeInspection
 * @noinspection ReturnTypeCanBeDeclaredInspection
 */
namespace PlisioPhpSdk\Models\Withdraw\Json;

use PlisioPhpSdk\Models\Withdraw\WithdrawApiResponse;
use PlisioPhpSdk\Models\Withdraw\WithdrawResponse;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use PlisioPhpSdk\Common\Annotations\DependsOn;

/**
 * @DependsOn(dependencyClass="PlisioPhpSdk\Models\Fee\Json\FeeParamsDenormalizer")
 */
class WithdrawApiResponseDenormalizer implements DenormalizerInterface
{
    use DenormalizerAwareTrait;

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return new WithdrawApiResponse(
            $data['status'],
            new WithdrawResponse(
                $data['data']['type'],
                $data['data']['status'],
                $data['data']['psys_cid'],
                $data['data']['currency'],
                $data['data']['source_currency'],
                $data['data']['source_rate'],
                $data['data']['fee'],
                $data['data']['wallet_hash'],
                $data['data']['sendmany'],
                $this->denormalizer->denormalize($data['data']['params'], $type, $format, $context),
                $data['data']['created_at_utc'],
                $data['data']['amount'],
                $data['data']['tx_url'],
                $data['data']['tx_id'],
                $data['data']['id'],
            )
        );
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === WithdrawApiResponse::class;
    }
}