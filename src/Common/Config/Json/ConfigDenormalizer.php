<?php

/**
 * @noinspection ReturnTypeCanBeDeclaredInspection
 * @noinspection PhpMissingReturnTypeInspection
 */

namespace PlisioPhpSdk\Common\Config\Json;

use PlisioPhpSdk\Common\Config\Auth;
use PlisioPhpSdk\Common\Config\Config;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ConfigDenormalizer implements DenormalizerInterface
{
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $conf = new Config($data['api_key'], $data['base_uri'], $data['current_env']);

        if (array_key_exists('auth', $data)) {
            $conf->setAuth(new Auth($data['auth']['user'], $data['auth']['password']));
        }

        return $conf;
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === Config::class;
    }
}
