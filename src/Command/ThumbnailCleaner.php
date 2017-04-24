<?php
declare(strict_types=1);

namespace Dada\Command;


use Dada\Entity\File;
use Dada\Repository\FileRepository;
use Dada\Service\Doctrine;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ThumbnailCleaner
 * @package Dada\Command
 */
class ThumbnailCleaner extends AbstractCommand
{
    /**
     * Configure the command
     */
    protected function configure() : void
    {
        parent::configure();
        $this->setName('clean-thumbs');
        $this->setDescription('Clean your thumbnails list');
        $this->setHelp('Remove unused/obsolete thumbnails from your cache');
    }

    /**
     * Main method : execute the command
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        /** @var FileRepository $fileRepository */
        $fileRepository = Doctrine::getManager()->getRepository(File::class);
        $allThumbs = $fileRepository->getThumbs();
        $allThumbsCopy = $allThumbs;

        // Checking used thumbnails
        for ($i = 0; $i < count($allThumbs); $i++) {
            if (is_file($this->getThumbsDir() . $allThumbs[$i])) {
                unset($allThumbs[$i]);
                $i--;
            } else {
                /** @var File $file */
                $file = $fileRepository->findOneBy(['thumbnail' => $allThumbs[$i]]);
                if (!$file) {
                    $this->output('<error>Inconsistent data.  Please clean and rebuild the index</error>');
                    exit(1);
                } else {
                    $file->setThumbnail(null);
                }
            }
        }

        // Checking existing thumbnails
        $thumbsIterator = new \DirectoryIterator($this->getThumbsDir());
        foreach ($thumbsIterator as $thumb) {
            if (!in_array($thumb->getFilename(), $allThumbsCopy)) {
                unlink($this->getThumbsDir() . $thumb->getFilename());
            }
        }

        return;
    }
}