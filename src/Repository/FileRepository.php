<?php
declare(strict_types=1);

namespace Dada\Repository;

/**
 * FileRepository
 */
class FileRepository extends \Doctrine\ORM\EntityRepository
{
    public function getChecksum()
    {
        return $this->createQueryBuilder('f')
            ->select('f.md5sum')
            ->getQuery()
            ->getScalarResult();
    }
}
