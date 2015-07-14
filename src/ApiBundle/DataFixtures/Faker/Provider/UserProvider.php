<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\DataFixtures\Faker\Provider;

use ApiBundle\Entity\User;
use ApiBundle\Utils\UserRoles;
use Faker\Provider\Base as BaseProvider;

/**
 * Faker provider for users.
 *
 * @see    ApiBundle\Entity\User
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class UserProvider
{
    /**
     * @var UserRoles
     */
    private $userRoles;

    /**
     * @param UserRoles $userRoles
     */
    public function __construct(UserRoles $userRoles)
    {
        $this->userRoles = $userRoles;
    }

    /**
     * The first call generate unique values. This is to ensure all values are called before generating duplicates.
     *
     * @return string Random Symfony role.
     *
     * TODO: take into account users hierarchy too!
     */
    public function userRole()
    {
        return BaseProvider::randomElement($this->userRoles->getRoles());
    }

    /**
     * @param string|null $type If specified, return the type value. See {@see User::getAllowedTypes()} to see valid
     *                          type names; if is invalid will return en empty array. Otherwise return an array with a
     *                          random of types.
     *
     * @return array Array of user types.
     */
    public function userTypes($type = null)
    {
        $allowedTypes = User::getAllowedTypes();

        if (null === $type) {
            return BaseProvider::randomElements($allowedTypes, BaseProvider::numberBetween(1, count($allowedTypes)));
        }

        return (isset($allowedTypes[$type]))
            ? [$allowedTypes[$type]]
            : []
        ;
    }
}
