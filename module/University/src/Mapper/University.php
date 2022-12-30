<?php

namespace University\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * University Mapper
 */
class University extends AbstractMapper implements MapperInterface
{
    /**
     * Get Entity Repository
     */
    public function getEntityRepository()
    {
        return $this->getEntityManager()->getRepository('University\\Entity\\University');
    }

    public function fetchAll(array $params, $order = null, $asc = false)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('c');
        $cacheKey = 'university_';

        $sort = ($asc === false) ? 'DESC' : 'ASC';
        if (is_null($order)) {
            $qb->orderBy('c.createdAt', $sort);
        } else {
            $qb->orderBy('c.' . $order, $sort);
        }
 
        $query = $qb->getQuery();
        $query->useQueryCache(true);
        $query->useResultCache(true, 600, $cacheKey);
        return $query;
    }
}
