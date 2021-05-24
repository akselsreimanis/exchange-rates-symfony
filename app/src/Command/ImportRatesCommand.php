<?php

namespace App\Command;

use App\Service\RatesService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportRatesCommand extends Command
{
    protected static $defaultName = 'rates:import';
    protected static string $defaultDescription = 'Import exchange rates from RSS Feed';

    private RatesService $ratesService;

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
        ;
    }

    public function __construct(
        RatesService $ratesService
    ) {
        parent::__construct();
        $this->ratesService = $ratesService;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $this->ratesService->importDataFromRss();
        } catch (\Exception $exception) {
            $io->error($exception->getMessage());

            return 0;
        }

        $io->success('Rates successfully imported!');

        return 0;
    }
}
