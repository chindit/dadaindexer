<?php
declare(strict_types=1);

namespace Dada\Command;


use Dada\Resources\Type;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class FileChecker
 * @package Dada\Command
 */
class FileChecker extends AbstractCommand
{
    /**
     * Configure the command
     */
    protected function configure() : void
    {
        parent::configure();
        $this->setName('check-filetype');
        $this->setDescription('Check file extension');
        $this->setHelp('Check file extension and adapt it to match MIME type');
        $this->addOption('file', 'f', InputOption::VALUE_OPTIONAL, 'File to check');
    }

    /**
     * Main method : execute the command
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::getConfig($input, $output);
        if (($input->hasOption('file')) ? $input->getOption('file') : null) {
            $file = (is_file($input->getOption('file'))) ? $input->getOption('file') : __DIR__ . $input->getOption('file');
            if (!is_file($file)) {
                $output->writeln('<error>Given file does not exists!</error>');
                return;
            }
            $this->output('<comment>This function is experimental.  Currently, only images are checked</comment>');
            $this->output('<info>File «' . $file . '» ' . (self::getCorrectExtension($file)) ? 'is valid' : 'had an incorrect extension');
        }

        $this->loopDir(($input->hasOption('directory')) ? $input->getOption('directory') : __DIR__);


        return;
    }

    /**
     * Return true if extension is correct otherwise fix it and return false
     * @param string $file
     * @return bool
     */
    public static function getCorrectExtension(string $file) : bool
    {
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($fileInfo, $file);
        if(!array_key_exists($mime, Type::getMimeArray())) {
            return true;
        } else {
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            if(Type::getMimeArray()[$mime] != strtolower($extension)){
                if($mime == 'image/jpeg'){
                    if(strtolower($extension) == 'jpeg')
                        return true;
                }
                //Si on est ici, c'est qu'il faut renommer le fichier
                $filename = pathinfo($file, PATHINFO_FILENAME);
                $dirName = pathinfo($file, PATHINFO_DIRNAME);
                rename($file, $dirName.$filename.'.'.Type::getMimeArray()[$mime]);
                return false;
            }
            return true;
        }
    }

    /**
     * Loop recursively on a directory
     * @param string $directory
     */
    private function loopDir(string $directory)
    {
        $iterator = new \DirectoryIterator($directory);

        foreach ($iterator as $file) {
            if ($file->getFilename() == '.' || $file->getFilename() == '..') {
                continue;
            }
            if ($file->isFile()) {
                if (!self::getCorrectExtension($file->getPathname())) {
                    $this->output('<info>File «' . $file->getPathname() . '» had wrong extension</info>');
                }
            } elseif ($file->isDir()) {
                $this->loopDir($file->getPathname());
            }
        }
    }
}
