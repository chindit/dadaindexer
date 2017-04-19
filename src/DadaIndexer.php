<?php
declare(strict_types=1);


namespace Dada;

use Dada\Command\FileChecker;
use Dada\Command\FullIndexer;
use Dada\Command\IndexCleaner;
use Dada\Command\Indexer;
use Dada\Command\ThumbnailCleaner;
use Dada\Command\Thumbnailer;
use Symfony\Component\Console\Application;

/**
 * Class DadaIndexer
 */
class DadaIndexer extends Application
{
    protected function getDefaultCommands() : array
    {
        $commands = parent::getDefaultCommands();
        $commands[] = new Indexer();
        $commands[] = new FileChecker();
        $commands[] = new FullIndexer();
        $commands[] = new IndexCleaner();
        $commands[] = new ThumbnailCleaner();
        $commands[] = new Thumbnailer();

        return $commands;
    }

}