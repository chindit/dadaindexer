<?php
declare(strict_types=1);

namespace Dada\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Thumbnailer extends AbstractCommand
{
    protected function configure() : void
    {
        parent::configure();
        $this->setName('mkthumbs');
        $this->setDescription('Create thumbnails for your collection');
        $this->setHelp('Generate missing thumbnails for your picture collection');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->getConfig($input, $output);

        return;
    }
}