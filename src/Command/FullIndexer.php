<?php
declare(strict_types=1);

namespace Dada\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class FullIndexer
 * @package Dada\Command
 */
class FullIndexer extends AbstractCommand
{
    /**
     * Configure command
     */
    protected function configure() : void
    {
        parent::configure();
        $this->setName('full-index');
        $this->setDescription('Perform a full index');
        $this->setHelp('Clean, index and generate thumbnails for your collection');
    }

    /**
     * Main method : execute command
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        // First, clean the index
        $this->output('<info>Step 1/4: Cleaning the index</info>');
        $indexCleaner = new IndexCleaner();
        $indexCleaner->execute($input, $output);

        // Then clean thumbnails
        $this->output('<info>Step 2/4: Cleaning old thumbnails</info>');
        $thumbnailsCleaner = new ThumbnailCleaner();
        $thumbnailsCleaner->execute($input, $output);

        // Then index
        $this->output('<info>Step 3/4: Updating index</info>');
        $indexer = new Indexer();
        $indexer->execute($input, $output);

        // And finally, generate new thumbnails
        $this->output('<info>Step 4/4: Generating new thumnbnails</info>');
        $thumbnailer = new Thumbnailer();
        $thumbnailer->execute($input, $output);

        return;
    }
}