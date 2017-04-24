<?php
declare(strict_types=1);

namespace Dada\Command;

use Dada\Entity\Directory;
use Dada\Entity\File;
use Dada\Repository\DirectoryRepository;
use Dada\Resources\Type;
use Dada\Service\Doctrine;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Indexer
 * @package Dada\Command
 *
 * Index a directory with all its files
 */
class Indexer extends AbstractCommand
{
    private $simulate = false;
    private $keepDuplicates = false;
    /** @var OutputInterface */
    private $output;
    private $config;

    /**
     * Constructor
     */
    protected function configure(): void
    {
        parent::configure();
        $this->setName('index');
        $this->setDescription('Index your collection');
        $this->setHelp('Perform a simple index of your picture collection');
        $this->addOption('simulate', null, InputOption::VALUE_OPTIONAL, 'Simulate query and don\'t modify DB');
        $this->addOption('keep-duplicates', null, InputOption::VALUE_OPTIONAL,
            'If a duplicate file is detected, it\'s skipped instead of being moved');
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
        // Execution time
        $timeStart = microtime(true);

        $this->output = $output;

        // Loading config
        parent::execute($input, $output);
        // Retrieving config
        $this->config = $this->getConfig($input, $output);
        // Loading user args
        $this->checkCustomParameters($input);
        // Indexing
        $this->startIndexing();

        $output->writeln('<info>Process took ' . round((microtime(true) - $timeStart), 3) . ' seconds.</info>');
        return;
    }

    /**
     * Check parameters specific to this command
     * @param InputInterface $input
     */
    private function checkCustomParameters(InputInterface $input): void
    {
        $this->simulate = $input->hasParameterOption('--simulate');
        $this->keepDuplicates = $input->hasParameterOption('--keep-duplicates');
    }

    /**
     * Index current directory
     * @param string $directory
     * @param int $level
     * @param Directory|null $parent
     */
    private function indexDirectory(string $directory, int $level = 0, Directory $parent = null)
    {
        $iterator = new \DirectoryIterator($directory);

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $this->indexFile($file, $parent);
            } elseif ($file->isDir()) {
                // Skip unwanted directories
                if ($file->getFilename() == '.' || $file->getFilename() == '..'  || $this->isSystemDir($file) || $this->isIgnoredDir($file)) {
                    continue;
                }
                /** @var DirectoryRepository $directoryRepository */
                $directoryRepository = Doctrine::getManager()->getRepository(Directory::class);
                $currentDirectory =
                    $directoryRepository->dirExists($file->getBasename(),
                        $file->getFilename())
                    ?? $this->initDirectory($file, $level, $parent);

                // Outputting
                $this->output('<info>Visiting «' . $currentDirectory->getName() . '»</info>');

                $this->indexDirectory($file->getPathname(), ($level + 1), $currentDirectory);
            } else {
                $this->output('<error>Unable to visit «' . $file->getFilename() . '»</error>');
            }
        }
    }

    /**
     * Build basic directory structure
     * @param \DirectoryIterator $file
     * @param int $level
     * @param Directory|null $parent
     * @return Directory
     */
    private function initDirectory(\DirectoryIterator $file, int $level, Directory $parent = null) : Directory
    {
        $directory = new Directory($file, $level + 1, $parent);
        Doctrine::getManager()->persist($directory);
        if (!$this->simulate) {
            Doctrine::getManager()->flush();
        }
        return $directory;
    }

    /**
     * Index current file
     * @param \DirectoryIterator $file
     * @param Directory|null $parent
     */
    private function indexFile(\DirectoryIterator $file, Directory $parent = null)
    {
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);

        $currentFile = new File();
        $currentFile->setDirectory($parent);

        // Invalid or hidden files
        if(strpos($file->getFilename(), '.') === false || strpos($file->getFilename(), '.') == 0){
            $this->output('<info>File skipped : «' . $file->getFilename() . '»</info>');
            return;
        }

        // Ignored MIME types
        $currentFile->setMime(finfo_file($fileInfo, $file->getPathname()));
        finfo_close($fileInfo);
        if(in_array($currentFile->getMime(), $this->config['ignoredMime'])){
            $this->output('<info>File «' . $file->getFilename() . '» was ignored due to it\'s type</info>');
            return;
        }

        // Check if file exists
        $indexedFile = Doctrine::getManager()->getRepository(File::class)->findOneBy(['path' => $this->getRelativePath($file), 'name' => $file->getFilename()]);
        if ($indexedFile) {
            return;
        }

        // Index file
        $currentFile->setMd5sum(md5_file($file->getPathName()));
        $currentFile->setType(Type::getType($currentFile->getMime()));
        $currentFile->setName($file->getFilename());
        $currentFile->setDirectory($parent);
        $currentFile->setWeight($file->getSize());
        $currentFile->setPath($this->getRelativePath($file));

        if ($currentFile->getType() == File::PICTURE) {
            $size = getimagesize($file->getPathname());
            $currentFile->setHeight($size[1]);
            $currentFile->setWidth($size[0]);
        }

        // Check for duplicate
        $indexedFile = Doctrine::getManager()->getRepository(File::class)->findOneBy(['md5sum' => $currentFile->getMd5sum()]);
        if ($indexedFile) {
            $this->output('<comment>File «' . $file->getFilename() . '» is detected as duplicate.</comment>');
            if (!$this->keepDuplicates) {
                $this->moveDuplicate($file);
            }
            return;
        }

        // Persist is deactivated in case of simulation
        if (!$this->simulate) {
            Doctrine::getManager()->persist($currentFile);
            Doctrine::getManager()->flush();
        }
    }

    /**
     * Move duplicate file to duplicate directory
     *
     * @param \DirectoryIterator $file
     */
    private function moveDuplicate(\DirectoryIterator $file) : void
    {
        rename($file->getPathname(), $this->getDuplicateDir() . $file->getFilename());
    }

    /**
     * Special method used to create the root directory of a new index
     */
    private function startIndexing() : void
    {
        $baseIterator = new \DirectoryIterator($this->dir);
        $baseDirectory = $this->initDirectory($baseIterator, 0);
        $baseDirectory->setPath($baseIterator->getRealPath());
        Doctrine::getManager()->flush();

        // Launch indexation process
        $this->indexDirectory($baseDirectory->getPath(), 1, $baseDirectory);
    }
}
