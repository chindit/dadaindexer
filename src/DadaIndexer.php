<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: david
 * Date: 18/04/2017
 * Time: 07:45
 */

namespace DadaIndexer;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class DadaIndexer
 */
class DadaIndexer extends Command
{

    protected function configure()
    {
        $this
            ->setName('action')
            ->setDescription('Perform an action with the indexer')
            ->setHelp('Allowed actions are: index, mkthumbs, check-filetype, clean-index, clean-thumbs and complete-index')
            ->addArgument(
                'action',
                InputArgument::REQUIRED,
                'Which action do you want to perform ?'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        switch ($input->getArgument('action')) {
            case 'index':
                break;
            case 'mkthumbs':
                break;
            case 'check-filetype':
                break;
            case 'clean-index':
                break;
            case 'clean-thumbs':
                break;
            case 'complete-index':
                break;
            default:
                $io = new SymfonyStyle($input, $output);
                $io->caution(['Your command is not recognized.',
                    'Allowed actions are',
                    'index : Perform a full index',
                    'mkthumbs : Create thumbnails for your collection',
                    'check-filetype : Change file extensions according to MIME',
                    'clean-index : Clean index for obsolete entries',
                    'clean-thumbs : Remove unused thumbs',
                    'complete-index : Perform a complete index with thumbs and cleaning']);
        }
    }
}