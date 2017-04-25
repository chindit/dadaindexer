<?php
declare(strict_types=1);

namespace Dada\Command;


use Dada\Entity\Directory;
use Dada\Entity\File;
use Dada\Factory\ImageFactory;
use Dada\Service\Doctrine;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Thumbnailer
 * @package Dada\Command
 */
class Thumbnailer extends AbstractCommand
{
    private $keepAspectRatio = false;
    private $config;

    /**
     * Configure the command
     */
    protected function configure(): void
    {
        parent::configure();
        $this->setName('mkthumbs');
        $this->setDescription('Create thumbnails for your collection');
        $this->setHelp('Generate missing thumbnails for your picture collection');
        $this->addOption('keep-ratio', null, InputOption::VALUE_OPTIONAL, 'Keep image ratio when generating thumbs');
    }

    /**
     * Main method : execute the command
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);
        $this->config = $this->getConfig($input, $output);
        $this->keepAspectRatio = $input->hasParameterOption('--keep-ratio');
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
                            if ($file->getType() == File::PICTURE) {
                                $this->generateThumbnail($file);
                            }
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

    /**
     * Generate a thumbnail for given file
     * @param File $file
     */
    private function generateThumbnail(File $file): void
    {
        $gdObject = ImageFactory::create($this->dir . $file->getPath());
        if (!$gdObject) {
            $this->output('<comment>Picture «' . $file->getName() . '» is not a valid picture');
        }
        $thumb = null;
        if (!$this->config['thumbnails']['keepRatio']) {
            $thumb = imagecreatetruecolor($this->config['thumbnails']['width'], $this->config['thumbnails']['height']);
            imagecopyresized($thumb, $gdObject, 0, 0, 0, 0, $this->config['thumbnails']['width'],
                $this->config['thumbnails']['height'], $file->getWidth(), $file->getHeight());
        } else {
            $ratio = $this->getRatioSize($gdObject['width'], $gdObject['height']);
            $thumb = imagecreatetruecolor(($file->getWidth() * $ratio), ($file->getHeight()));
            imagecopyresized($thumb, $gdObject, 0, 0, 0, 0, ($file->getWidth() * $ratio), ($file->getHeight() * $ratio), $file->getWidth(), $file->getHeight());
        }
        $name = uniqid() . '.jpg';
        imagejpeg($thumb, $this->getThumbsDir() . $name);

        $file->setThumbnail($name);
        Doctrine::getManager()->flush();
    }

    /**
     * Return ratio calculation for given sizes
     * @param int $width
     * @param int $height
     * @return float
     */
    private function getRatioSize(int $width, int $height) : float
    {
        $ratioWidth = (float)($width / $this->config['thumbnails']['width']);
        $ratioHeight = (float)($height / $this->config['thumbnails']['height']);
        return ($ratioWidth > $ratioHeight) ? $ratioWidth : $ratioHeight;
    }
}