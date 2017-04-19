<?php
declare(strict_types=1);

namespace Dada\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FileChecker extends AbstractCommand
{
    protected function configure() : void
    {
        parent::configure();
        $this->setName('check-filetype');
        $this->setDescription('Check file extension');
        $this->setHelp('Check file extension and adapt it to match MIME type');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->getConfig($input, $output);

        return;
    }
}