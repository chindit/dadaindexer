<?php

namespace Dada\Service;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;

/**
 * Class Doctrine
 * @package Dada\Service
 *
 * Doctrine Wrapper
 */
class Doctrine
{
    /** @var  Doctrine */
    private static $doctrine;
    /** @var EntityManager */
    private $entityManager;

    /**
     * Doctrine constructor.
     * @param array $config
     */
    protected function __construct(array $config)
    {
        $paths = array(__DIR__ . '/../Entity/');
        $isDevMode = false;
        $dbParams = array(
            'dbname' => $config['base'],
            'user' => $config['user'],
            'password' => $config['pass'],
            'host' => $config['server'],
            'driver' => (strpos($config['driver'], 'pdo_') === 0) ? $config['driver'] : 'pdo_' . $config['driver']
        );

        $config = Setup::createConfiguration($isDevMode);
        $driver = new AnnotationDriver(new AnnotationReader(), $paths);
        AnnotationRegistry::registerLoader('class_exists');
        $config->setMetadataDriverImpl($driver);
        $config->setAutoGenerateProxyClasses(true);
        $this->entityManager = EntityManager::create($dbParams, $config);
    }

    /**
     * Doctrine getter to create singleton
     * @param array $config
     * @return Doctrine
     */
    public static function getInstance(array $config)
    {
        if (!self::$doctrine) {
            self::$doctrine = new Doctrine($config);
        }
        return self::$doctrine;
    }

    /**
     * Getter for EntityManager
     * @return EntityManager
     */
    public static function getManager()
    {
        if (!self::$doctrine) {
            throw new \RuntimeException("Can't return manager.  Database connection is not initiated");
        }
        return self::$doctrine->entityManager;
    }
}