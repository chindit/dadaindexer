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

    /**
     * Get all files of a directory
     * @param string $path
     * @return array
     */
    public function findByPath(Directory $directory)
    {
        return $this->createQueryBuilder('f')
            ->select('f.name')
            ->where('f.directory = :directory')
            ->setParameter('directory', $directory)
            ->getQuery()
            ->getScalarResult();
    }

    /**
     * Count number of files with missing checksum
     * @return int
     */
    public function countMissingChecksums() : int
    {
        return intval($this->createQueryBuilder('f')
            ->select('COUNT(f.id)')
            ->where('f.md5sum IS NULL')
            ->getQuery()
            ->getSingleScalarResult());
    }

    /**
     * Return first $max files without checksum
     * @param int $max
     * @return array
     */
    public function getFilesWithoutChecksum(int $max)
    {
        return $this->createQueryBuilder('f')
            ->where('f.md5sum IS NULL')
            ->setMaxResults($max)
            ->getQuery()
            ->getResult();
    }
}
