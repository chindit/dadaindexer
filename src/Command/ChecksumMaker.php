<?php
declare(strict_types=1);

namespace Dada\Command;


use Dada\Repository\FileRepository;
use Dada\Service\Doctrine;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChecksumMaker extends AbstractCommand
{
    private $config;

    /**
     * Command definition
     */
    protected function configure(): void
    {
        parent::configure();
        $this->setName('checksum');
        $this->setDescription('Calculate missing checksum');
        $this->setHelp('Calculate missing checksum for your current index');
    }

    /**
     * Main method for Command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);
        // Retrieving config
        $this->config = $this->getConfig($input, $output);

        /** @var FileRepository $fileRepository */
        $fileRepository = Doctrine::getManager()->getRepository(FileRepository::class);
        if ($fileRepository->countMissingChecksums() > 0) {
            /*while ($fileBlock = $fileRepository->getFilesWithoutChecksum(1000)) {
                if (!is_file($this->dir . ))
            }*/
        } else {
            $this->output('<info>No checksum is missing</info>');
            return;
        }
    }
}