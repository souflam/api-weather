<?php

namespace App\Command;

use App\Service\LoadCityIntoDatabase;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:load-cities',
    description: 'Load cities coming from musement API into Our DB',
)]
class LoadCitiesCommand extends Command
{
    private LoadCityIntoDatabase $loadCityIntoDatabase;

    public function __construct(LoadCityIntoDatabase $loadCityIntoDatabase, string $name = null)
    {
        parent::__construct($name);
        $this->loadCityIntoDatabase = $loadCityIntoDatabase;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->loadCityIntoDatabase->loadCitiesIntoDatabase($output);

        $io->success('End LoadCities');

        return Command::SUCCESS;
    }
}
