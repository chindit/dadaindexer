<?php
declare(strict_types=1);

namespace Dada\Command;


use Dada\Service\Doctrine;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

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
        if ($input->getOption('configuration') && !$this->customConfigLoaded) {
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
        // Initiating Doctrine
        Doctrine::getInstance($this->config);
        return $this->config;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getConfig($input, $output);
        $this->doctrinePreCheck($output);
    }

    private function doctrinePreCheck(OutputInterface $output)
    {
        try {
            $schemaTool = new \Doctrine\ORM\Tools\SchemaTool(Doctrine::getManager());
            $classes = Doctrine::getManager()->getMetadataFactory()->getAllMetadata();
            $schemaTool->createSchema($classes);
        } catch (\Exception $e) {
            $output->writeln('<error>Unable to create tables in database</error>');
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            exit(1);
        }
    }
}