<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Utils;

/**
 * Class UserRoles.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class UserRoles
{
    /**
     * @var array Hierarchy of roles registered by the Security component.
     *
     * @see Symfony\Component\Security\Core\Role\RoleHierarchy
     */
    private $hierarchy;

    /**
     * @param array $hierarchy Hierarchy of registered roles
     */
    public function __construct(array $hierarchy)
    {
        $this->hierarchy = $hierarchy;
    }

    /**
     * @return array list of registered roles
     */
    public function getRoles()
    {
        return array_keys($this->extractRoles($this->hierarchy));
    }

    /**
     * @param array $hierarchy
     *
     * @return array Array with roles as keys
     */
    private function extractRoles(array $hierarchy)
    {
        $return = [];

        foreach ($hierarchy as $role => $roles) {
            $return[$role] = null;
            foreach ($roles as $subRole) {
                $return[$subRole] = null;
            }
        }

        return $return;
    }
}
