<?php

/** @noinspection PhpUnhandledExceptionInspection */
namespace PlisioPhpSdk;

require_once dirname(__DIR__) . '/utils/searcher.php';
require_once getAutoloadFile();

use DI\ContainerBuilder;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\PsrCachedReader;
use Doctrine\Common\Annotations\Reader;
use GuzzleHttp\Client;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PlisioPhpSdk\Commands\LoadConfCommand;
use PlisioPhpSdk\Commands\Test\BalanceCommand;
use PlisioPhpSdk\Commands\Test\CommissionCommand;
use PlisioPhpSdk\Commands\Test\CreateInvoiceCommand;
use PlisioPhpSdk\Commands\Test\CurrencyInfoCommand;
use PlisioPhpSdk\Commands\Test\FeeCommand;
use PlisioPhpSdk\Commands\Test\FeePlanCommand;
use PlisioPhpSdk\Commands\Test\OperationCommand;
use PlisioPhpSdk\Commands\Test\WithdrawCommand;
use PlisioPhpSdk\Common\Config\Config;
use PlisioPhpSdk\Common\Json\SerializerRegistry;
use PlisioPhpSdk\Http\Interaction;
use PlisioPhpSdk\Http\InteractionInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Symfony\Component\Cache\Adapter\PhpFilesAdapter;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

class PlisioPhpSdk
{
    private static ?ContainerInterface $container = null;

    private function __construct()
    {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Throwable
     */
    public static function get(): ContainerInterface
    {
        if (null === self::$container) {
            self::$container = self::build();
        }

        return self::$container;
    }

    private static function build(): ContainerInterface
    {
        $logger = self::initLogger();

        try {
            $cacheAdapter = self::initCache();
            $serializer = self::initSerializer(
                (new SerializerRegistry(
                    self::initAnnotationsReader($cacheAdapter, (bool) getenv('DEBUG'))
                ))->build()
            );
            $builder = new ContainerBuilder();
            $hasConfig = true;

            if ($cacheAdapter->hasItem('config')) {
                $conf = $serializer->deserialize($cacheAdapter->getItem('config')->get(), Config::class, 'json');
                $client = new Client(['base_uri' => $conf->getBaseUri()]);
                $builder->addDefinitions([
                    InteractionInterface::class => function (ContainerInterface $container) use ($logger, $client, $conf) {
                        return new Interaction(
                            $client,
                            $logger,
                            $container->get(SerializerInterface::class),
                            $conf
                        );
                    },
                    BalanceCommand::class => function (ContainerInterface $container) {
                        return new BalanceCommand($container->get(InteractionInterface::class));
                    },
                    CommissionCommand::class => function (ContainerInterface $container) {
                        return new CommissionCommand($container->get(InteractionInterface::class));
                    },
                    CreateInvoiceCommand::class => function (ContainerInterface $container) {
                        return new CreateInvoiceCommand($container->get(InteractionInterface::class));
                    },
                    CurrencyInfoCommand::class => function (ContainerInterface $container) {
                        return new CurrencyInfoCommand($container->get(InteractionInterface::class));
                    },
                    FeePlanCommand::class => function (ContainerInterface $container) {
                        return new FeePlanCommand($container->get(InteractionInterface::class));
                    },
                    OperationCommand::class => function (ContainerInterface $container) {
                        return new OperationCommand($container->get(InteractionInterface::class));
                    },
                    WithdrawCommand::class => function (ContainerInterface $container) {
                        return new WithdrawCommand($container->get(InteractionInterface::class));
                    },
                    FeeCommand::class => function (ContainerInterface $container) {
                        return new FeeCommand($container->get(InteractionInterface::class));
                    },
                ]);
            } else {
                $hasConfig = false;
            }

            $commands = [LoadConfCommand::class];
            if ($hasConfig) {
                $commands = array_merge(
                    $commands,
                    [
                        BalanceCommand::class,
                        CommissionCommand::class,
                        CreateInvoiceCommand::class,
                        CurrencyInfoCommand::class,
                        FeePlanCommand::class,
                        OperationCommand::class,
                        WithdrawCommand::class,
                        FeeCommand::class,
                    ]
                );
            }

            $builder->addDefinitions([
                SerializerInterface::class => function () use ($serializer) {
                    return $serializer;
                },
                LoadConfCommand::class => function (ContainerInterface $container) use ($cacheAdapter) {
                    return new LoadConfCommand($cacheAdapter, $container->get(SerializerInterface::class));
                },
                'console' => [
                    'commands' => $commands
                ]
            ]);

            return $builder->build();
        } catch (Throwable $e) {
            $logger->error($e->getMessage());
            throw $e;
        }
    }
    private static function initLogger(): LoggerInterface
    {
        $logFile = dirname(__DIR__).'/plisio-php-sdk.log';

        if (!file_exists($logFile)) {
            file_put_contents($logFile, '');
        }
        $logger = new Logger('plisio-php-sdk');
        $logger->pushHandler(new StreamHandler($logFile, Logger::ERROR));

        return $logger;
    }

    private static function initCache(): PhpFilesAdapter
    {
        $cacheDir = dirname(__DIR__).'/plisio-php-sdk-cache';

        if (!mkdir($cacheDir) && !is_dir($cacheDir)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $cacheDir));
        }

        return new PhpFilesAdapter('plisio-php-sdk.cache', 0, $cacheDir, true);
    }

    private static function initSerializer(array $registry): SerializerInterface
    {
        return new Serializer($registry, [new JsonEncoder()]);
    }

    private static function initAnnotationsReader(PhpFilesAdapter $adapter, bool $debug): Reader
    {
        return new PsrCachedReader(new AnnotationReader(), $adapter, $debug);
    }
}
