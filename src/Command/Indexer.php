<?php
declare(strict_types=1);

namespace Dada\Command;

use Dada\Entity\Directory;
use Dada\Entity\File;
use Dada\Repository\DirectoryRepository;
use Dada\Repository\FileRepository;
use Dada\Resources\Type;
use Dada\Service\Doctrine;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

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
    private $checkDuplicates = false;
    private $report = false;
    private $reportContent = [];
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
        $this->addOption('check-duplicates', null, InputOption::VALUE_OPTIONAL, 'Check for duplicate files');
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


        if ($this->report) {
            file_put_contents($this->dir . 'report.txt', implode("\n", $this->reportContent) . "\n", FILE_APPEND);
        }
        $output->writeln('<info>Process took ' . round((microtime(true) - $timeStart), 3) . ' seconds.</info>');
        return;
    }

    /**
     * Check parameters specific to this command
     * @param InputInterface $input
     */
    private function checkCustomParameters(InputInterface $input): void
    {
        $this->simulate = $input->hasParameterOption('--simulate') || $this->config['options']['simulate'];
        $this->keepDuplicates = $input->hasParameterOption('--keep-duplicates') || $this->config['options']['keepDuplicates'];
        $this->checkDuplicates = $input->hasParameterOption('--check-duplicates') || $this->config['options']['checkDuplicates'];
        $this->report = $input->hasParameterOption('--report') || $this->config['options']['report'];

        // Check if we need to recalculate checksum
        if ($this->checkDuplicates) {
            /** @var FileRepository $fileRepository */
            $fileRepository = Doctrine::getManager()->getRepository(File::class);
            if ($fileRepository->countMissingChecksums() > 0) {
                /** @var QuestionHelper $helper */
                $helper = $this->getHelper('question');
                $question = new ConfirmationQuestion('Some indexed files doesn\'t have checksum.  Do you want to calculate it?',
                    false);

                if ($helper->ask($input, $this->output, $question)) {
                    $this->output->writeln('<info>Checksum calculation started.</info>');

                }
            }
        }
    }

    /**
     * Index current directory
     * @param string $directory
     * @param int $level
     * @param Directory|null $parent
     */
    private function indexDirectory(string $directory, int $level = 0, Directory $parent = null)
    {
        // Creating iterator
        $iterator = new \DirectoryIterator($directory);

        // Retrieve all files for this directory
        $fileList = [];
        if (!$this->simulate) {
            /** @var FileRepository $fileRepository */
            $fileRepository = Doctrine::getManager()->getRepository(File::class);
            $fileList = array_map('current', ($fileRepository->findByPath($parent)) ?: []);
        }
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                if (!in_array($file->getFilename(), $fileList)) {
                    $this->indexFile($file, $parent);
                }
            } elseif ($file->isDir()) {

                // Skipping unwanted directories
                if ($this->isSystemDir($iterator) || $this->isIgnoredDir($iterator)) {
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
                $this->reportContent[] = 'Visiting «' . $currentDirectory->getName() . '»';

                $this->indexDirectory($file->getPathname(), ($level + 1), $currentDirectory);
            } else {
                $this->output('<error>Unable to visit «' . $file->getFilename() . '»</error>');
                $this->reportContent[] = 'Unable to visit «' . $file->getFilename() . '»';
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
    private function initDirectory(\DirectoryIterator $file, int $level, Directory $parent = null): Directory
    {
        $this->reportContent[] = 'Starting indexing of «' . $file->getPathname() . '»';
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
        if (strpos($file->getFilename(), '.') === false || strpos($file->getFilename(), '.') == 0) {
            $this->output('<info>File skipped : «' . $file->getFilename() . '»</info>');
            $this->reportContent[] = 'File skipped : «' . $file->getPathname() . '»';
            return;
        }

        // Ignored MIME types
        $currentFile->setMime(finfo_file($fileInfo, $file->getPathname()));
        finfo_close($fileInfo);
        if (in_array($currentFile->getMime(), $this->config['mime']['ignoredMime'])) {
            $this->output('<info>File «' . $file->getFilename() . '» was ignored due to it\'s type</info>');
            $this->reportContent[] = 'File «' . $file->getPathname() . '» was ignored due to it\'s type';
            return;
        }

        // Index file
        if ($this->checkDuplicates) {
            $currentFile->setMd5sum(md5_file($file->getPathName()));
        }
        $currentFile->setType(Type::getType($currentFile->getMime()));
        $currentFile->setName($file->getFilename());
        $currentFile->setDirectory($parent);
        $currentFile->setWeight($file->getSize());
        $currentFile->setPath($this->getRelativePath($file->getPathname()));

        if ($currentFile->getType() == File::PICTURE) {
            $size = getimagesize($file->getPathname());
            $currentFile->setHeight($size[1]);
            $currentFile->setWidth($size[0]);
        }

        // Check for duplicate
        if ($this->checkDuplicates) {
            /** @var File $indexedFile */
            $indexedFile = Doctrine::getManager()->getRepository(File::class)->findOneBy(['md5sum' => $currentFile->getMd5sum()]);
            if ($indexedFile) {
                $this->output('<comment>File «' . $file->getFilename() . '» is detected as duplicate.</comment>');
                $this->reportContent[] = 'File «' . $file->getPathname() . '» is detected as a duplicate of «' . $indexedFile->getPath() . '»';
                if (!$this->keepDuplicates) {
                    $this->moveDuplicate($file);
                }
                return;
            }
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
    private function moveDuplicate(\DirectoryIterator $file): void
    {
        rename($file->getPathname(), $this->getDuplicateDir() . $file->getFilename());
    }

    /**
     * Special method used to create the root directory of a new index
     */
    private function startIndexing(): void
    {
        /** @var DirectoryRepository $directoryRepository */
        $directoryRepository = Doctrine::getManager()->getRepository(Directory::class);
        $baseDirectory =
            $directoryRepository->dirExists($this->dir, '.')
            ?? call_user_func(function (): Directory {
                $baseIterator = new \DirectoryIterator($this->dir);
                $baseDirectory = $this->initDirectory($baseIterator, 0);
                $baseDirectory->setPath($this->addTrailingSlash($baseIterator->getRealPath()));
                if (!$this->simulate) {
                    Doctrine::getManager()->flush();
                }
                return $baseDirectory;
            });

        // Launch indexation process
        $this->indexDirectory($baseDirectory->getPath(), 1, $baseDirectory);
    }
}
