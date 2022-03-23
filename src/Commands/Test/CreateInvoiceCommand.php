<?php 

namespace PlisioPhpSdk\Commands\Test;

use PlisioPhpSdk\Common\Enum\Currencies;
use PlisioPhpSdk\Models\Invoice\InvoiceQuery;
use PlisioPhpSdk\Http\InteractionInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

class CreateInvoiceCommand extends Command
{
    private InteractionInterface $interaction;

    public function __construct(InteractionInterface $interaction)
    {
        parent::__construct();
        $this->interaction = $interaction;
    }

    protected function configure(): void
    {
        $this->setName('plisio-php-sdk:test-create-invoice');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $invoice = $this->interaction->createInvoice(
                (new InvoiceQuery(Currencies::TBTC, 'some order', '234sdfsd'))
                    ->setAmount('0.01')
            );
            if (null !== $invoice) {
                $output->writeln("<fg=green>Status: {$invoice->getStatus()}</>");
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
