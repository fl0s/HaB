<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EventRepository extends EntityRepository
{
    public function findBetweenDates(\DateTime $start, \DateTime $end)
    {
        return $this->createQueryBuilder('e')
            ->where('e.date >= :start')
            ->andWhere('e.date <= :end')
            ->orderBy('e.date', 'ASC')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getQuery()
            ->getResult()
        ;
    }
}
