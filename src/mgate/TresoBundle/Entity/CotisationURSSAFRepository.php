<?php

namespace mgate\TresoBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CotisationURSSAFRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CotisationURSSAFRepository extends EntityRepository
{
    /**
     * Renvoie les cotisations pour une date donnée
     * YEAR MONTH DAY sont défini dans DashBoardBundle/DQL (qui doit devenir FrontEndBundle)
     * @return array
     */
    public function findAllByDate(\DateTime $date) {
        $qb = $this->_em->createQueryBuilder();
        
        $date = $date->format('Y-m-d');
      
        $query = $qb->select('c')
                     ->from('mgateTresoBundle:CotisationURSSAF', 'c')
                     ->where("'$date' >= c.dateDebut")
                     ->andWhere("'$date' <= c.dateFin"); 
                 
        return $query->getQuery()->getResult();;
    }
}
