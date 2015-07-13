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

use ApiBundle\Utils\UserRoles;
use Faker\Generator;
use Faker\Provider\Base as BaseProvider;

/**
 * Class UserProvider.
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
     * Constructor.
     *
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
}
