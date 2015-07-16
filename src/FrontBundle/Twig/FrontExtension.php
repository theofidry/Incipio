<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FrontBundle\Twig;

use FrontBundle\Utils\RoleHierarchyHelper;

/**
 * Class FrontExtension: class used to create custom Twig functionalities and filters.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class FrontExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('uriId', [$this, 'uriIdFilter']),
            new \Twig_SimpleFilter('userTopRole', [$this, 'userTopRoleFilter']),
        ];
    }

    /**
     * Extract the ID which is given in URI form (typically in the @id tag).
     *
     * This is done by extracting the last part of the URI.
     *
     * @example
     *
     *  uriIdFilter('/api/users/101')            // "101"
     *  uriIdFilter('/api/mandates/AaKxazRT')    // "AaKxazRT"
     *  uriIdFilter('/api/')                     // ""
     *
     * @param $uri
     *
     * @return string
     */
    public function uriIdFilter($uri)
    {
        return substr(strrchr($uri, '/'), 1);
    }

    /**
     * Reformat role in a clean way. This filter assumes that the roles passed are known to {@see
     * RoleHierarchyHelper} and formatted following the ROLE_%s mask.
     *
     * @example
     *  roleFilter(['ROLE_USER'])         // "user"
     *  roleFilter(['ROLE_ADMIN'])        // "admin"
     *  roleFilter(['ROLE_SUPER_ADMIN'])  // "root"
     *
     * @param array $roles Array of valid Symfony roles.
     *
     * @return string Formatted top role if role known, empty string otherwise.
     */
    public function userTopRoleFilter(array $roles)
    {
        $topRole = RoleHierarchyHelper::getTopLevelRole($roles);

        if (null === $topRole) {
            return '';
        }

        if ('ROLE_SUPER_ADMIN' === $topRole) {
            return 'root';
        }

        return strtolower(substr($topRole, 5));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'front_extension';
    }
}
