<?php
declare(strict_types=1);

namespace Dada\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AbstractCommand
 * @package Command
 */
abstract class AbstractCommand extends Command
{
    private $config;
    private $customConfigLoaded = false;

    /**
     * AbstractCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->config = parse_ini_file(__DIR__ . '/../Resources/config.ini');
    }

    protected function configure()
    {
        parent::configure();
        $this->setDefinition(
            new InputDefinition(array(
                new InputOption('configuration', 'c', InputOption::VALUE_OPTIONAL),
            ))
        );
    }

    protected function getConfig(InputInterface $input, OutputInterface $output) : array
    {
        if ($input->hasOption('configuration') && !$this->customConfigLoaded) {
            $filePath = $input->getOption('configuration');
            $customConfig = parse_ini_file($filePath);
            if ($customConfig) {
                $this->config = array_merge($this->config, $customConfig);
            } else {
                $output->writeln('<error>Your config is invalid</error>');
                exit(1);
            }
            $this->customConfigLoaded = true;
        }
        return $this->config;
    }
}