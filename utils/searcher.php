<?php

/**
 * @throws Exception
 */
function getAutoloadFile(): string
{
    $possibleFiles = [
        dirname(__DIR__).'/../../autoload.php',
        dirname(__DIR__).'/../autoload.php',
        dirname(__DIR__).'/vendor/autoload.php'
    ];

    $file = null;
    foreach ($possibleFiles as $possibleFile) {
        if (file_exists($possibleFile)) {
            $file = $possibleFile;
            break;
        }
    }
    if (null === $file) {
        throw new RuntimeException('Cannot find autoload.php file');
    }

    return $file;
}
