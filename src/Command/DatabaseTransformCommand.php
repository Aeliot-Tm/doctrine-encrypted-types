<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class DatabaseTransformCommand extends Command
{
    protected function configure(): void
    {
        $this->addArgument('manager', InputArgument::REQUIRED, 'Entity manager name');
        $this->addOption('dump-sql', null, InputOption::VALUE_NONE, 'Dump sql instead of its execution');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $passedOutput = $input->getOption('dump-sql') ? $output : null;
        $this->transform($input->getArgument('manager'), $passedOutput);

        return 0;
    }

    abstract protected function transform(string $managerName, ?OutputInterface $output): void;
}
