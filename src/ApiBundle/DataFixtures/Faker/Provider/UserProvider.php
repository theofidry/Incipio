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
class UserProvider extends BaseProvider
{
    /**
     * @var UserRoles
     */
    private $userRoles;

    /**
     * Constructor.
     *
     * @param Generator $generator
     * @param UserRoles $userRoles
     */
    public function __construct(Generator $generator, UserRoles $userRoles)
    {
        parent::__construct($generator);

        $this->userRoles = $userRoles;
    }

    /**
     * The first call generate unique values. This is to ensure all values are called before generating deplicates.
     *
     * @return string Random Symfony role.
     *
     * TODO: take into account users hierarchy too!
     */
    public function userRole()
    {
        return self::randomElement($this->userRoles->getRoles());
    }
}
