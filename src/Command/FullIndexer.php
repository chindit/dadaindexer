<?php
declare(strict_types=1);

namespace Dada\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FullIndexer extends AbstractCommand
{
    protected function configure() : void
    {
        parent::configure();
        $this->setName('full-index');
        $this->setDescription('Perform a full index');
        $this->setHelp('Clean, index and generate thumbnails for your collection');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->getConfig($input, $output);

        return;
    }
}