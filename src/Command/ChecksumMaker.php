<?php
declare(strict_types=1);

namespace Dada\Command;


use Dada\Entity\File;
use Dada\Repository\FileRepository;
use Dada\Service\Doctrine;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChecksumMaker extends AbstractCommand
{
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
        $startTime = microtime(true);

        parent::execute($input, $output);
        // Retrieving config
        $this->config = $this->getConfig($input, $output);

        /** @var FileRepository $fileRepository */
        $fileRepository = Doctrine::getManager()->getRepository(File::class);
        if (($fileCount = $fileRepository->countMissingChecksums()) > 0) {
            $this->output('<info>' . $fileCount . ' checksums will be calculated</info>');
            $progressBar = new ProgressBar($output, $fileCount);
            while ($fileBlock = $fileRepository->getFilesWithoutChecksum(1000)) {
                /** @var File $file */
                foreach ($fileBlock as $file) {
                    if (!is_file($this->dir . $file->getPath())) {
                        /**
                         * Changing checksum to empty string will remove it from query
                         * We could delete the file but it's not the job of this command.
                         * A «clean-index» should be launched to clear out these cases.
                         */
                        $file->setMd5sum('');
                    } else {
                        $file->setMd5sum(md5_file($this->dir . $file->getPath()));
                    }
                    $progressBar->advance();
                }
                // Flushing changes to avoid infinite loop
                Doctrine::getManager()->flush();
            }
        } else {
            $this->output('<info>No checksum is missing</info>');
            return;
        }
        $progressBar->finish();
        $this->output('');
        $this->output('<info>Process took ' . round((microtime(true) - $startTime), 2) . ' seconds');
    }
}