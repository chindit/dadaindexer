<?php
declare(strict_types=1);

namespace Dada\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class IndexCleaner extends AbstractCommand
{
    protected function configure() : void
    {
        parent::configure();
        $this->setName('clean-index');
        $this->setDescription('Clean your index');
        $this->setHelp('Remove obsolete entries from your collection');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->getConfig($input, $output);

        return;
    }
}