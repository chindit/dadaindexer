<?php
declare(strict_types=1);

namespace Dada\Command;


use Dada\Entity\Directory;
use Dada\Entity\File;
use Dada\Service\Doctrine;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class IndexCleaner
 *
 * @package Dada\Command
 */
class IndexCleaner extends AbstractCommand
{
    /**
     * Command definition
     */
    protected function configure(): void
    {
        parent::configure();
        $this->setName('clean');
        $this->setDescription('Clean your index');
        $this->setHelp('Remove obsolete entries from your collection');
    }

    /**
     * Main method.  Launch command
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        Doctrine::getInstance($this->getConfig($input, $output));
        parent::execute($input, $output);
        $this->cleaner();
    }

    /**
     * Clean the index
     */
    private function cleaner() : void
    {
        // Get list of directories
        $directoryList = Doctrine::getManager()->getRepository(Directory::class)->findAll();

        /** @var Directory $directory */
        foreach ($directoryList as $directory) {
            $fileList = Doctrine::getManager()->getRepository(File::class)->findBy(['directory' => $directory]);
            if (!is_dir($directory->getPath())) {
                /** @var File $file */
                foreach ($fileList as $file) {
                    Doctrine::getManager()->remove($file);
                }
                Doctrine::getManager()->remove($directory);
                Doctrine::getManager()->flush();
            } else {
                /** @var File $file */
                foreach ($fileList as $file) {
                    if (!is_file($directory->getPath() . '/' . $file->getName())) {
                        Doctrine::getManager()->remove($file);
                    }
                }
                Doctrine::getManager()->flush();
            }
        }
    }
}
