<?php

namespace App\Command;

use App\Service\LoadForeCast;
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

    public function __construct(LoadForeCast $loadForeCast, string $name = null)
    {
        parent::__construct($name);
        $this->loadForeCast = $loadForeCast;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->loadForeCast->loadForCast($output);
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
