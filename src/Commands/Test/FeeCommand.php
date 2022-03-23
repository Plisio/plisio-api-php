<?php

namespace PlisioPhpSdk\Commands\Test;

use PlisioPhpSdk\Common\Enum\Currencies;
use PlisioPhpSdk\Http\InteractionInterface;
use PlisioPhpSdk\Models\Fee\FeeQuery;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

class FeeCommand extends Command
{
    private InteractionInterface $interaction;

    public function __construct(InteractionInterface $interaction)
    {
        parent::__construct();
        $this->interaction = $interaction;
    }

    protected function configure(): void
    {
        $this->setName('plisio-php-sdk:test-fee');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $fee = $this->interaction->getFee(
                new FeeQuery(
                    Currencies::TBTC,
                    'tb1qfqtvgh97umdum8zwyah4ztzkwz8j7qyyalgwa4',
                    '0.0003'
                )
            );
            if (null !== $fee) {
                $output->writeln("<fg=green>Status: {$fee->getStatus()}</>");
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
