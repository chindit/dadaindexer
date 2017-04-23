<?php
declare(strict_types=1);

namespace Dada\Repository;

/**
 * FileRepository
 */
class FileRepository extends \Doctrine\ORM\EntityRepository
{
    public function getThumbs()
    {
        return $this->createQueryBuilder('f')
            ->select('f.thumbnail')
            ->getQuery()
            ->getScalarResult();
    }
}
