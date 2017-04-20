<?php
declare(strict_types=1);

namespace Dada\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Indexer extends AbstractCommand
{
    private $simulate = false;
    private $splitDirs = false;

    protected function configure() : void
    {
        parent::configure();
        $this->setName('index');
        $this->setDescription('Index your collection');
        $this->setHelp('Perform a simple index of your picture collection');
        $this->addOption('simulate', null, InputOption::VALUE_OPTIONAL, 'Simulate query and don\'t modify DB');
        $this->addOption('split-dirs', null, InputOption::VALUE_OPTIONAL, 'Split directories and put them in their own table');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);
        $this->checkCustomParameters($input);

        return;
    }

    private function checkCustomParameters(InputInterface $input) : void
    {
        $this->simulate = $input->hasParameterOption('--simulate');
        $this->splitDirs = $input->hasParameterOption('--split-dirs');
    }
}