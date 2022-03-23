<?php

namespace PlisioPhpSdk\Commands\Test;

use PlisioPhpSdk\Common\Enum\Currencies;
use PlisioPhpSdk\Common\Enum\FeePlans;
use PlisioPhpSdk\Models\Withdraw\WithdrawQuery;
use PlisioPhpSdk\Http\InteractionInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

class WithdrawCommand extends Command
{
    private InteractionInterface $interaction;

    public function __construct(InteractionInterface $interaction)
    {
        parent::__construct();
        $this->interaction = $interaction;
    }

    protected function configure(): void
    {
        $this->setName('plisio-php-sdk:test-withdraw');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $withdraw = $this->interaction->withdraw(
                new WithdrawQuery(
                    Currencies::TBTC,
                    '2N3cD7vQxBqmHFVFrgK2o7HonHnVoFxxDVB',
                    '0.00031',
                    FeePlans::NORMAL,
                    1
                )
            );
            if (null !== $withdraw) {
                $output->writeln("<fg=green>Status: {$withdraw->getStatus()}</>");
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
