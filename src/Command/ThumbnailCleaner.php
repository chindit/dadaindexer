<?php
declare(strict_types=1);

namespace Dada\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ThumbnailCleaner extends AbstractCommand
{
    protected function configure() : void
    {
        parent::configure();
        $this->setName('clean-thumbs');
        $this->setDescription('Clean your thumbnails list');
        $this->setHelp('Remove unused/obsolete thumbnails from your cache');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->getConfig($input, $output);

        return;
    }
}