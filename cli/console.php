<?php /** @noinspection PhpUnhandledExceptionInspection */

require_once dirname(__DIR__) . '/utils/searcher.php';
require_once getAutoloadFile();

use PlisioPhpSdk\PlisioPhpSdk;
use Symfony\Component\Console\Application;

$app = new Application('plisio-php-sdk');
$container = PlisioPhpSdk::get();

foreach ($container->get('console')['commands'] as $command) {
    $app->add($container->get($command));
}

$app->run();
