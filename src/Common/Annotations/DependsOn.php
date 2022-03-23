<?php

namespace PlisioPhpSdk\Common\Annotations;

use Exception;
use Webmozart\Assert\Assert;

/**
 * @Annotation
 * @NamedArgumentConstructor
 * @Target("CLASS")
 */
class DependsOn
{
    private string $dependencyClass;

    /**
     * @throws Exception
     */
    public function __construct(string $dependencyClass)
    {
        Assert::classExists($dependencyClass);
        $this->dependencyClass = $dependencyClass;
    }

    public function getDependencyClass(): string
    {
        return $this->dependencyClass;
    }
}
