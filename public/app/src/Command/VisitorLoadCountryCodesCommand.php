<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\VisitorServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\Service\Attribute\Required;

#[AsCommand(
    name: 'visitor:load-country-codes',
    description: 'Add a short description for your command',
)]
class VisitorLoadCountryCodesCommand extends Command
{
    #[Required]
    public VisitorServiceInterface $visitorService;

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->visitorService->initCountryCodes();

        $io->success('Load country codes to storage');

        return Command::SUCCESS;
    }
}
