<?php
declare(strict_types=1);

namespace Dada\Command;


use Dada\Entity\Directory;
use Dada\Entity\File;
use Dada\Service\Doctrine;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Class IndexDestroyer
 * @package Dada\Command
 */
class IndexDestroyer extends AbstractCommand
{
    /**
     * Configure the command
     */
    protected function configure() : void
    {
        parent::configure();
        $this->setName('destroy');
        $this->setDescription('Destroy your index');
        $this->setHelp('Remove all entries from your collection');
    }

    /**
     * Main method : execute the command
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Do you really want to destroy your current index ? (y/N) ', false);

        if (!$helper->ask($input, $output, $question)) {
            $output->writeln('<info>Purge canceled.</info>');
            return;
        }

        Doctrine::getInstance(parent::getConfig($input, $output));
        $tables = [Doctrine::getManager()->getClassMetadata(File::class),
            Doctrine::getManager()->getClassMetadata(Directory::class)];
        $connection = Doctrine::getManager()->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        foreach ($tables as $table) {
            $connection->beginTransaction();
            try {
                $connection->query('SET FOREIGN_KEY_CHECKS=0');
                $q = $dbPlatform->getTruncateTableSql($table->getTableName());
                $connection->executeUpdate($q);
                $connection->query('SET FOREIGN_KEY_CHECKS=1');
                $connection->commit();
            } catch (\Exception $e) {
                $connection->rollback();
                $output->writeln('<comment>Unable to destroy index.  Returned error is following: ' . $e->getMessage() . '</comment>');
            }
        }
        $output->writeln('<info>Purge done</info>');
        return;
    }
}