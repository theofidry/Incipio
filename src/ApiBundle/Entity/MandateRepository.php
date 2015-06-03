<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class MandateRepository.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class MandateRepository extends EntityRepository
{
    /**
     * @return int Current mandate.
     */
    public function findCurrent()
    {
        $query = $this
            ->createQueryBuilder('m')
            ->select('m')
            ->where('startAt < :currentDate')
            ->andWhere('endAt > :currentDate')
            ->setParameter('currentDate', new \DateTime(), \Doctrine\DBAL\Types\Type::DATETIME)
//            ->orderBy('m.startAt', 'desc')
            ->addOrderBy('last_login', 'ASC NULLS FIRST')
            ->getQuery()
            ->getSQL();

        return $query;

        return $this->getEntityManager()
            ->createQueryBuilder('m')
            ->where('m.startAt < :currentDate')
            ->setParameter('currentDate', new \DateTime(), \Doctrine\DBAL\Types\Type::DATETIME)
            ->andWhere('m.endAt > :currentDate')
            ->orderBy('m.startAt', 'desc')
            ->addOrderBy('m.endAt', 'DESC NULL FIRST')
            ->getQuery()
            ->getResult()
        ;
    }
}
