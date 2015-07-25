<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Doctrine\ORM;

use ApiBundle\Entity\User;
use FOS\UserBundle\Doctrine\UserManager as BaseUserManager;
use FOS\UserBundle\Model\UserInterface;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class UserManager extends BaseUserManager
{
    /**
     * {@inheritdoc}
     */
    public function updateCanonicalFields(UserInterface $user)
    {
        parent::updateCanonicalFields($user);

        if ($user instanceof User) {
            $user->setOrganizationEmailCanonical($this->canonicalizeEmail($user->getOrganisationEmail()));
        }
    }
}
