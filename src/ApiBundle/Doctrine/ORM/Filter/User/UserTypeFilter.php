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
 * Filter to filter on user's type.
 *
 * @example
 *  /api/users?filter[where][mandate]=/api/mandates/5
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class UserTypeFilter extends AbstractResourceSearchFilter
{
    /**
     * {@inheritdoc}
     */
    public function applyFilter(ResourceInterface $resource, QueryBuilder $queryBuilder, array $queryValues)
    {
        // ?filter[where][type]=TYPE_CONTRACTOR
        // ?filter[where][type]=contractor
        if (isset($queryValues['type']) && is_string($queryValues['type'])) {
            if (isset(User::getAllowedTypes()[$queryValues['type']])) {
                $type = User::getAllowedTypes()[$queryValues['type']];
            } elseif (in_array($queryValues['type'], User::getAllowedTypes())) {
                $type = $queryValues['type'];
            } else {
                return;
            }

            //TODO: secure parameters
            $queryBuilder
                ->andWhere('o.types LIKE :user_type')
                ->setParameter('user_type', sprintf('%%%s%%', $type))
            ;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getResourceClass()
    {
        return User::class;
    }
}
