<?php
declare(strict_types=1);

namespace Dada\Repository;

use Dada\Entity\Directory;

/**
 * FileRepository
 */
class DirectoryRepository extends \Doctrine\ORM\EntityRepository
{
    public function dirExists(string $path, string $name) : ?Directory
    {
        return $this->createQueryBuilder('d')
            ->where('d.path = :path')
            ->andWhere('d.name = :name')
            ->setParameter('path', $path)
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
