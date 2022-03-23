<?php

/** @noinspection ReturnTypeCanBeDeclaredInspection */
namespace PlisioPhpSdk\Commands;

use PlisioPhpSdk\Common\Config\Auth;
use PlisioPhpSdk\Common\Config\Config;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\PhpFilesAdapter;
use Symfony\Component\Cache\CacheItem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Yaml\Yaml;
use Webmozart\Assert\Assert;

class LoadConfCommand extends Command
{
    private PhpFilesAdapter $cache;
    private SerializerInterface $serializer;

    public function __construct(PhpFilesAdapter $cache, SerializerInterface $serializer)
    {
        parent::__construct();
        $this->cache = $cache;
        $this->serializer = $serializer;
    }

    protected function configure()
    {
        $this
            ->setName('plisio-php-sdk:load-conf')
            ->setDescription('Load config from external .yaml file');

        $this->addArgument('path', InputArgument::REQUIRED, 'Path to .yaml config');
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');

        /** @var CacheItem $configItem */
        $configItem = $this->cache->getItem('config');

        $configItem->set($this->serializer->serialize(self::loadConfig($path), 'json'));
        $this->cache->save($configItem);
    }

    private static function loadConfig(string $path): Config
    {
        Assert::fileExists($path);
        $confAssoc = Yaml::parse(file_get_contents($path));

        Assert::notEmpty(
            $confAssoc['plisio-php-sdk']['current-env'],
            "Configuration problem, section: 'current-env' must not be empty"
        );

        $envKey = $confAssoc['plisio-php-sdk']['current-env'];
        Assert::oneOf($envKey, ['prod', 'dev']);

        foreach (self::availableKeysByEnv($envKey) as $availableKey) {
            Assert::keyExists(
                $confAssoc['plisio-php-sdk']['common'][$envKey],
                $availableKey,
                "Required key: '$availableKey' for env: '$envKey' missed"
            );
        }

        $config = new Config(
            $confAssoc['plisio-php-sdk']['common'][$envKey]['api-key'],
            $confAssoc['plisio-php-sdk']['common'][$envKey]['base-uri'],
            $envKey,
            (bool) $confAssoc['plisio-php-sdk']['silent']
        );

        if ('dev' === $envKey) {
            $config->setAuth(new Auth(
                $confAssoc['plisio-php-sdk']['common'][$envKey]['user'],
                $confAssoc['plisio-php-sdk']['common'][$envKey]['password']
            ));
        }

        return $config;
    }

    private static function availableKeysByEnv(string $env): array
    {
        $keys = [
            'prod' => ['base-uri', 'api-key'],
            'dev' => ['base-uri', 'api-key', 'user', 'password']
        ];

        return $keys[$env];
    }
}
