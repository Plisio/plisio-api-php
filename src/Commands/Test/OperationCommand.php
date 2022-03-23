<?php 

namespace PlisioPhpSdk\Commands\Test;

use PlisioPhpSdk\Http\InteractionInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

class OperationCommand extends Command
{
    private InteractionInterface $interaction;

    public function __construct(InteractionInterface $interaction)
    {
        parent::__construct();
        $this->interaction = $interaction;
    }

    protected function configure(): void
    {
        $this->setName('plisio-php-sdk:test-operation');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $operation = $this->interaction->getOperationById('61e9384388ecfd3ea775dfb2');
            if (null !== $operation) {
                $output->writeln("<fg=green>Status: {$operation->getStatus()}</>");
            } else {
                $output->writeln("<fg=yellow>Some problem, response is null, see logs</>");
            }
        } catch (Throwable $e) {
            $output->writeln("<fg=red>Error: {$e->getMessage()}</>");
            return 1;
        }

        return 0;
    }
}
