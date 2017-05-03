<?php
declare(strict_types=1);

namespace Dada\Command;


use Dada\Entity\Directory;
use Dada\Service\Doctrine;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Class AbstractCommand
 * @package Command
 */
abstract class AbstractCommand extends Command
{
    protected $config;
    private $customConfigLoaded = false;
    /** @var OutputInterface */
    private $output;
    protected $dir;
    private $thumbsDir;
    private $duplicateDir;

    /**
     * AbstractCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->config = parse_ini_file(__DIR__ . '/../Resources/config.ini', true);
    }

    /**
     * Command definition
     */
    protected function configure()
    {
        parent::configure();
        $this->setDefinition(
            new InputDefinition(array(
                new InputOption('configuration', 'c', InputOption::VALUE_OPTIONAL),
            ))
        );
        $this->addOption('directory', 'd', InputOption::VALUE_OPTIONAL, 'Directory to index');
    }

    /**
     * Loading default and user config
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return array
     */
    protected function getConfig(InputInterface $input, OutputInterface $output) : array
    {
        //Setting output
        $this->output = $output;

        //Loading config
        if ($input->getOption('configuration') && !$this->customConfigLoaded) {
            $filePath = $input->getOption('configuration');
            $customConfig = parse_ini_file($filePath, true);
            if ($customConfig) {
                $this->config = array_replace_recursive($this->config, $customConfig);
            } else {
                $output->writeln('<error>Your config is invalid</error>');
                exit(1);
            }
            $this->customConfigLoaded = true;
        }
        // Initiating Doctrine
        Doctrine::getInstance($this->config);

        return $this->config;
    }

    /**
     * Output a message to the User
     * @param string $output
     */
    protected function output (string $output)
    {
        $this->output->writeLn($output);
    }

    /**
     * Pre-checks before executing command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getConfig($input, $output);
        $this->doctrinePreCheck($output);
        $this->directoryHelper($input);
        $this->createSystemDirs();
    }

    /**
     * Create SQL tables if needed
     *
     * @param OutputInterface $output
     */
    private function doctrinePreCheck(OutputInterface $output)
    {
        try {
            $schemaManager = Doctrine::getManager()->getConnection()->getSchemaManager();
            if ($schemaManager->tablesExist(array('file', 'directory')) != true) {
                $schemaTool = new \Doctrine\ORM\Tools\SchemaTool(Doctrine::getManager());
                $classes = Doctrine::getManager()->getMetadataFactory()->getAllMetadata();
                $schemaTool->createSchema($classes);
            }
        } catch (\Exception $e) {
            $output->writeln('<error>Unable to create tables in database</error>');
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            exit(1);
        }
    }

    /**
     * Check directory entered by User
     * @param InputInterface $input
     */
    private function directoryHelper(InputInterface $input) : void
    {
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');
        $this->dir = $input->getOption('directory');
        if (is_null($this->dir)) {
            // No directory, getting Index root directory
            /** @var Directory $dir */
            if ($dir = Doctrine::getManager()->getRepository(Directory::class)->findOneBy(['parent' => null])) {
                $this->dir = $this->addTrailingSlash($dir->getPath());
                return;
            }
            // No directory stored.  Asking for default
            $question = new ConfirmationQuestion('You haven\'t indicated a base directory for the index.
            By default, it will be 
            «' . __DIR__ . '».
            Is it correct ? (y/N)', false);
            if (!$helper->ask($input, $this->output, $question)) {
                $this->output('<info>Action canceled by user request</info>');
                exit(1);
            } else {
                $this->dir = __DIR__;
            }
        } elseif (!is_dir($this->dir)) {
            $question = new ConfirmationQuestion('The directory you\'ve entered is not valid.  Do you want to use «'
                . __DIR__ . '» instead ?');
            if (!$helper->ask($input, $this->output, $question)) {
                $this->output('<info>Action canceled by user request</info>');
                exit(1);
            } else {
                $this->dir = __DIR__;
            }
        }

        // Add trailing slash
        $this->dir = $this->addTrailingSlash(realpath($this->dir));
    }

    /**
     * Create system directories, used for duplicates and thumbnails
     */
    private function createSystemDirs() : void
    {
        // Thumbs dir
        $this->thumbsDir = (substr($this->config['directories']['thumbsPath'], 0, 1) === '/')
            ? $this->config['directories']['thumbsPath'] : $this->dir . $this->config['directories']['thumbsPath'];
        if (!is_dir($this->thumbsDir)) {
            if (!mkdir($this->thumbsDir, 0777, true)) {
                $this->output('<error>Unable to create system dir</error>');
                exit(1);
            }
        }
        // Duplicate dir
        $this->duplicateDir = (substr($this->config['directories']['duplicatePath'], 0, 1) === '/')
            ? $this->config['directories']['duplicatePath'] : $this->dir . $this->config['directories']['duplicatePath'];
        if (!is_dir($this->duplicateDir)) {
            if (!mkdir($this->duplicateDir, 0777, true)) {
                $this->output('<error>Unable to create system dir</error>');
                exit(1);
            }
        }
    }

    /**
     * Return full path to thumbnails directory
     * @return string
     */
    protected function getThumbsDir() : string
    {
        return $this->thumbsDir;
    }

    /**
     * Return full path to duplicate directory
     * @return string
     */
    protected function getDuplicateDir() : string
    {
        return $this->duplicateDir;
    }

    /**
     * Check if given directory is a system directory
     * @param \DirectoryIterator $directory
     * @return bool
     */
    protected function isSystemDir(\DirectoryIterator $directory) : bool
    {
        return ($this->addTrailingSlash($directory->getPathname()) == $this->getThumbsDir()
            || $this->addTrailingSlash($directory->getPathname()) == $this->getDuplicateDir()
            || substr($directory->getFilename(), 0, 1) == '.');
    }

    /**
     * Check if given directory is ignored by User
     * @param \DirectoryIterator $directory
     * @return bool
     */
    protected function isIgnoredDir(\DirectoryIterator $directory) : bool
    {
        foreach ($this->config['directories']['ignoredPath'] as $ignoredDir) {
            $path = (substr($ignoredDir, 0, 1) === '/') ? $ignoredDir : $this->dir . $ignoredDir;
            if ($path == $directory->getPathname()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Return relative path to base index path
     * @param \DirectoryIterator $file
     * @return string
     */
    protected function getRelativePath(string $file) : string
    {
        return (substr($file, strlen($this->dir)));
    }

    /**
     * Add a trailing slash to given path
     * @param string $path
     * @return string
     */
    protected function addTrailingSlash(string $path) : string
    {
        return (substr($path, -1) === '/') ? $path : $path . '/';
    }
}