<?php
declare(strict_types=1);

namespace Dada\Command;

use Dada\Entity\Directory;
use Dada\Entity\File;
use Dada\Repository\DirectoryRepository;
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
    private $splitDirs = false;
    private $dir = __DIR__;
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
        $this->addOption('directory', 'd', InputOption::VALUE_OPTIONAL, 'Directory to index');
        $this->addOption('simulate', null, InputOption::VALUE_OPTIONAL, 'Simulate query and don\'t modify DB');
        $this->addOption('split-dirs', null, InputOption::VALUE_OPTIONAL,
            'Split directories and put them in their own table');
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
        $this->indexDirectory($this->dir);

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
        $this->splitDirs = $input->hasParameterOption('--split-dirs');

        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');
        $dir = $input->getOption('directory') ?? __DIR__;
        if (is_null($dir)) {
            $question = new ConfirmationQuestion('You haven\'t indicated a base directory for the index.  By default, it
         will be «' . __DIR__ . '».  Is it correct ?', false);
            if (!$helper->ask($input, $this->output, $question)) {
                $this->output('<info>Clean canceled by user request</info>');
                return;
            } else {
                $this->dir = __DIR__;
            }
        } elseif (!is_dir($dir)) {
            $question = new ConfirmationQuestion('The directory you\'ve entered is not valid.  Do you want to use «'
                . __DIR__ . '» instead ?');
            if (!$helper->ask($input, $this->output, $question)) {
                $this->output('<info>Clean canceled by user request</info>');
                return;
            } else {
                $this->dir = __DIR__;
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
        $iterator = new \DirectoryIterator($directory);

        foreach ($iterator as $file) {
            if ($file->getFilename() == '.' || $file->getFilename() == '..') {
                continue;
            }
            if ($file->isFile()) {
                $this->indexFile($file, $parent);
            } elseif ($file->isDir()) {
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
        $indexedFile = Doctrine::getManager()->getRepository(File::class)->findOneBy(['path' => $file->getBasename(), 'name' => $file->getFilename()]);
        if ($indexedFile) {
            return;
        }

        // Index file
        $currentFile->setMd5sum(md5_file($file->getPathName()));
        $currentFile->setType(Type::getType($currentFile->getMime()));
        $currentFile->setName($file->getFilename());
        $currentFile->setDirectory($parent);
        $currentFile->setWeight($file->getSize());
        $currentFile->setPath($file->getBasename());

        if ($currentFile->getType() == File::PICTURE) {
            $size = getimagesize($file->getPathname());
            $currentFile->setHeight($size[0]);
            $currentFile->setWidth($size[1]);
        }

        // Check for duplicate
        $indexedFile = Doctrine::getManager()->getRepository(File::class)->findOneBy(['md5sum' => $currentFile->getMd5sum()]);
        if ($indexedFile) {
            $this->output('<comment>File «' . $file->getFilename() . '» is detected as duplicate.</comment>');
            $this->moveDuplicate($file);
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
        $duplicateDir = (substr($this->config['duplicatePath'], 0, 1) == '/') ? $this->config['duplicatePath'] : __DIR__ . '/' . $this->config['duplicatePath'];
        if (!is_dir($duplicateDir)) {
            mkdir($duplicateDir);
        }
        rename($file->getPathname(), $duplicateDir . '/' . $file->getFilename());
    }
}
