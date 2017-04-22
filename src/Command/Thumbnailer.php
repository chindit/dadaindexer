<?php
declare(strict_types=1);

namespace Dada\Command;


use Dada\Entity\Directory;
use Dada\Entity\File;
use Dada\Service\Doctrine;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Thumbnailer extends AbstractCommand
{
    protected function configure() : void
    {
        parent::configure();
        $this->setName('mkthumbs');
        $this->setDescription('Create thumbnails for your collection');
        $this->setHelp('Generate missing thumbnails for your picture collection');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        Doctrine::getInstance($this->getConfig($input, $output));
        // Get list of directories
        $directoryList = Doctrine::getManager()->getRepository(Directory::class)->findAll();

        /** @var Directory $directory */
        foreach ($directoryList as $directory) {
            $fileList = Doctrine::getManager()->getRepository(File::class)->findBy(['directory' => $directory]);
            if (is_dir($directory->getPath())) {
                /** @var File $file */
                foreach ($fileList as $file) {
                    if (is_file($directory->getPath() . '/' . $file->getName())) {
                        if (is_file($this->getThumbsDir() . $file->getThumbnail())) {
                            continue;
                        } else {

                        }
                    }
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
        return;
    }
}