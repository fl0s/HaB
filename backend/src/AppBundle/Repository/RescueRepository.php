<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Rescue;
use Doctrine\ORM\EntityRepository;

class RescueRepository extends EntityRepository
{
    public function countTransport()
    {
        return $this->createQueryBuilder('r')
            ->select('count(r)')
            ->where('r.transport = 1')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function count()
    {
        return $this->createQueryBuilder('r')
            ->select('count(r)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countByType()
    {
        $results =  $this->createQueryBuilder('r')
            ->select('COUNT(r) AS cnt, t.name')
            ->leftJoin('r.type', 't')
            ->groupBy('r.type')
            ->getQuery()
            ->getResult();

        return array_column($results, 'cnt', 'name');
    }

    public function countByProvider()
    {
        $results = $this->createQueryBuilder('r')
            ->select('COUNT(r) AS cnt, p.name')
            ->leftJoin('r.provider', 'p')
            ->groupBy('r.provider')
            ->getQuery()
            ->getResult();

        return array_column($results, 'cnt', 'name');
    }
}
