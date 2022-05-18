<?php

namespace App\Command;

use App\Service\LoadForeCast;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:load-forecast',
    description: 'Add a short description for your command',
)]
class LoadForecastCommand extends Command
{
    private LoadForeCast $loadForeCast;
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger, LoadForeCast $loadForeCast, string $name = null)
    {
        parent::__construct($name);
        $this->loadForeCast = $loadForeCast;
        $this->logger = $logger;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $io = new SymfonyStyle($input, $output);
            $this->loadForeCast->loadForCast($output);
            $io->success('loading Forecast is end');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            //log everythings
            $this->logger->warning(get_class($e) . ': ' . $e->getMessage() . ' in ' . $e->getFile()
                . ' on line ' . $e->getLine());

            return Command::FAILURE;
        }
    }
}
