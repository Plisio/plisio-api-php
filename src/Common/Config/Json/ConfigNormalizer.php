<?php

/**
 * @noinspection ReturnTypeCanBeDeclaredInspection
 * @noinspection PhpMissingReturnTypeInspection
 */

namespace PlisioPhpSdk\Common\Config\Json;

use PlisioPhpSdk\Common\Config\Config;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ConfigNormalizer implements NormalizerInterface
{
    /**
     * @param Config $object
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $config = [
            'api_key' => $object->getApiKey(),
            'base_uri' => $object->getBaseUri(),
            'current_env' => $object->getCurrentEnv()
        ];
        if (null !== $auth = $object->getAuth()) {
            $config['auth'] = ['user' => $auth->getUser(), 'password' => $auth->getPassword()];
        }

        return $config;
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof Config;
    }
}
