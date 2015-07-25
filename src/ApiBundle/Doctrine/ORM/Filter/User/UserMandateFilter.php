<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Doctrine\ORM\Filter\User;

use ApiBundle\Doctrine\ORM\Filter\AbstractResourceSearchFilter;
use ApiBundle\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Dunglas\ApiBundle\Api\ResourceInterface;

/**
 * Filter to filter on user's mandate.
 *
 * @example
 *  /api/users?filter[where][mandate]=/api/mandates/5
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class UserMandateFilter extends AbstractResourceSearchFilter
{
    /**
     * {@inheritdoc}
     */
    protected function applyFilter(ResourceInterface $resource, QueryBuilder $queryBuilder, array $queryValues)
    {
        if (!isset($queryValues['mandate']) || !is_string($queryValues['mandate'])) {
            return;
        }

        $mandateId = $this->getFilterValueFromUrl($queryValues['mandate']);
        //TODO: secure parameters
        $queryBuilder
            ->leftJoin('o.jobs', 'user_jobs_alias')
            ->andWhere('user_jobs_alias.mandate = :user_mandate_id')
            ->setParameter('user_mandate_id', $mandateId)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function getResourceClass()
    {
        return User::class;
    }
}
