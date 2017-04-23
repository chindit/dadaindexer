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

class Thumbnailer extends AbstractCommand
{
    private $keepAspectRatio = false;
    private $config;

    protected function configure(): void
    {
        parent::configure();
        $this->setName('mkthumbs');
        $this->setDescription('Create thumbnails for your collection');
        $this->setHelp('Generate missing thumbnails for your picture collection');
        $this->addOption('keep-ratio', null, InputOption::VALUE_OPTIONAL, 'Keep image ratio when generating thumbs');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->config = $this->getConfig($input, $output);
        Doctrine::getInstance($this->config);
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

    private function generateThumbnail(File $file): void
    {
        $gdObject = ImageFactory::create($file->getPath() . $file->getName());
        if (!$gdObject) {
            $this->output('<comment>Picture «' . $file->getName() . '» is not a valid picture');
        }
        $thumb = null;
        if (!$this->config['keepRatio']) {
            $thumb = imagecreatetruecolor($this->config['thumbSize']['width'], $this->config['thumbSize']['height']);
            imagecopyresized($thumb, $gdObject, 0, 0, 0, 0, $this->config['thumbSize']['width'],
                $this->config['thumbSize']['height'], $file->getWidth(), $file->getHeight());
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

    private function getRatioSize($width, $height)
    {
        $ratioWidth = $width / $this->config['thumbSize']['width'];
        $ratioHeight = $height / $this->config['thumbSize']['height'];
        return ($ratioWidth > $ratioHeight) ? $ratioWidth : $ratioHeight;
    }
}