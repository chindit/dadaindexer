<?php
declare(strict_types=1);


namespace Dada;

use Dada\Command\Indexer;
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

        return $commands;
    }
}