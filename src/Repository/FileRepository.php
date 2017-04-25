<?php
declare(strict_types=1);

namespace Dada\Repository;

use Dada\Entity\Directory;

/**
 * FileRepository
 */
class FileRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Get thumbnails list
     * @return array
     */
    public function getThumbs()
    {
        return $this->createQueryBuilder('f')
            ->select('f.thumbnail')
            ->getQuery()
            ->getScalarResult();
    }

    public function findByPath(string $path)
    {
        return $this->createQueryBuilder('f')
            ->join(Directory::class, 'd')
            ->where('d.path = :path')
            ->setParameter('path', $path)
            ->getQuery()
            ->getResult();
    }
}
