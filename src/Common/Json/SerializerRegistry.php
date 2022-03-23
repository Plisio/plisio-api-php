<?php

namespace PlisioPhpSdk\Common\Json;

use Doctrine\Common\Annotations\Reader;
use PlisioPhpSdk\Common\Annotations\DependsOn;
use PlisioPhpSdk\Common\Config\Json\ConfigDenormalizer;
use PlisioPhpSdk\Common\Config\Json\ConfigNormalizer;
use PlisioPhpSdk\Models\Balance\Json\BalanceApiResponseDenormalizer;
use PlisioPhpSdk\Models\Balance\Json\BalanceResponseDenormalizer;
use PlisioPhpSdk\Models\Commission\Json\CommissionApiResponseDenormalizer;
use PlisioPhpSdk\Models\Cryptocurrency\Json\CryptocurrencyApiResponseDenormalizer;
use PlisioPhpSdk\Models\Fee\Json\FeeApiResponseDenormalizer;
use PlisioPhpSdk\Models\Fee\Json\FeeParamsDenormalizer;
use PlisioPhpSdk\Models\Fee\Json\FeePlanApiResponseDenormalizer;
use PlisioPhpSdk\Models\Fee\Json\FeePlanItemDenormalizer;
use PlisioPhpSdk\Models\Invoice\Json\InvoiceWhiteLabelResponseDenormalizer;
use PlisioPhpSdk\Models\Operation\Json\OperationApiResponseDenormalizer;
use PlisioPhpSdk\Models\Operation\Json\OperationDenormalizer;
use PlisioPhpSdk\Models\Operation\Json\OperationParamsDenormalizer;
use PlisioPhpSdk\Models\Paysys\Json\PaysysDenormalizer;
use PlisioPhpSdk\Models\Withdraw\Json\WithdrawApiResponseDenormalizer;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Webmozart\Assert\Assert;

class SerializerRegistry
{
    private Reader $reader;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @throws ReflectionException
     */
    public function build(): array
    {
        $initialized = [];

        foreach (self::getAll() as $type => $value) {
            foreach ($value as $class) {
                $this->initialize($class, $initialized, $type);
            }
        }

        return array_values($initialized);
    }

    public static function getAll(): array
    {
        return [
            'denormalizer' => [
                BalanceApiResponseDenormalizer::class,
                BalanceResponseDenormalizer::class,
                OperationApiResponseDenormalizer::class,
                OperationDenormalizer::class,
                OperationParamsDenormalizer::class,
                FeeParamsDenormalizer::class,
                CryptocurrencyApiResponseDenormalizer::class,
                PaysysDenormalizer::class,
                CommissionApiResponseDenormalizer::class,
                FeePlanApiResponseDenormalizer::class,
                InvoiceWhiteLabelResponseDenormalizer::class,
                FeePlanItemDenormalizer::class,
                WithdrawApiResponseDenormalizer::class,
                FeeApiResponseDenormalizer::class,
                ConfigDenormalizer::class,
            ],
            'normalizer' => [
                ConfigNormalizer::class
            ]
        ];
    }

    /**
     * @throws ReflectionException
     */
    private function initialize(string $class, array &$initialized, string $type): void
    {
        $reflectionClass = new ReflectionClass($class);

        if (!array_key_exists($class, $initialized)) {
            $instance = $reflectionClass->newInstance();
            self::getInfoByType($type)['validation']($instance);
            $initialized[$class] = $instance;
        }

        if (null !== $dependency = $this->getDependencyClass($reflectionClass)) {
            $dependencyInstance = new $dependency();
            self::getInfoByType($type)['validation']($dependencyInstance);
            $initialized[$dependency] = $dependencyInstance;
            $setter = self::getInfoByType($type)['setter'];
            Assert::methodExists($initialized[$class], $setter);
            $initialized[$class]->$setter($initialized[$dependency]);

            $this->initialize($dependency, $initialized, $type);
        }
    }

    private static function getInfoByType(string $type): array
    {
        $info = [
            'normalizer' => [
                'validation' => fn ($normalizer) => Assert::isInstanceOf($normalizer, NormalizerInterface::class),
                'setter' => 'setNormalizer'
            ],
            'denormalizer' => [
                'validation' => fn ($denormalizer) => Assert::isInstanceOf($denormalizer, DenormalizerInterface::class),
                'setter' => 'setDenormalizer'
            ]
        ];
        Assert::keyExists($info, $type);

        return $info[$type];
    }

    private function getDependencyClass(ReflectionClass $class): ?string
    {
        $dependsOnAnnotation = $this->reader->getClassAnnotation($class, DependsOn::class);
        if (null !== $dependsOnAnnotation) {
            return $dependsOnAnnotation->getDependencyClass();
        }

        return null;
    }
}
