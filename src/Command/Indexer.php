<?php
declare(strict_types=1);

namespace Dada\Command;

use Dada\Entity\Directory;
use Dada\Entity\File;
use Dada\Service\Doctrine;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Indexer extends AbstractCommand
{
    private $simulate = false;
    private $splitDirs = false;
    private $dir = __DIR__;
    private $checksumList = [];
    private $config;

    protected function configure(): void
    {
        parent::configure();
        $this->setName('index');
        $this->setDescription('Index your collection');
        $this->setHelp('Perform a simple index of your picture collection');
        $this->addOption('directory', 'd', InputOption::VALUE_REQUIRED, 'Directory to index');
        $this->addOption('simulate', null, InputOption::VALUE_OPTIONAL, 'Simulate query and don\'t modify DB');
        $this->addOption('split-dirs', null, InputOption::VALUE_OPTIONAL,
            'Split directories and put them in their own table');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        // Execution time
        $timeStart = microtime(true);

        // Loading config
        parent::execute($input, $output);
        // Retrieving config
        $this->config = $this->getConfig($input, $output);
        // Loading user args
        $this->checkCustomParameters($input);
        // Indexing
        $this->indexDirectory($this->dir);

        $output->writeln('<info>Process took ' . round((microtime(true) - $timeStart), 3) . ' seconds.</info>');
        return;
    }

    private function checkCustomParameters(InputInterface $input): void
    {
        $this->simulate = $input->hasParameterOption('--simulate');
        $this->splitDirs = $input->hasParameterOption('--split-dirs');
        $this->dir = $input->getOption('directory') ?? __DIR__;
    }

    private function indexDirectory(string $directory, int $level = 0, Directory $parent = null)
    {
        $iterator = new \DirectoryIterator($directory);

        foreach ($iterator as $file) {
            if ($file->getFilename() == '.' || $file->getFilename() == '..') {
                continue;
            }
            if ($file->isFile()) {
                $this->indexFile($file, $parent);
            } elseif ($file->isDir()) {
                // Ignore hidden files
                if (in_array($file->getFilename(), $this->config['ignoredDir']) || (strpos($file->getFilename(),
                            '.') === 0)
                ) {
                    continue;
                }

                $currentDirectory =
                    Doctrine::getManager()->getRepository(Directory::class)->dirExists($file->getBasename(),
                        $file->getFilename())
                    ?? $this->initDirectory($file, $level, $parent);

                //TODO output
                $this->indexDirectory($file->getPathname(), ($level + 1), $currentDirectory);
            } else {
                //TODO output
            }
        }
    }

    private function initDirectory(\DirectoryIterator $file, int $level, Directory $parent = null) : Directory
    {
        $directory = new Directory($file, $level + 1, $parent);
        Doctrine::getManager()->persist($directory);
        if (!$this->simulate) {
            Doctrine::getManager()->flush();
        }
        return $directory;
    }

    private function indexFile(\DirectoryIterator $file, Directory $parent = null)
    {

    }
}
