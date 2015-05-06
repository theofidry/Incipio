<?php

namespace ApiBundle\Bundle\UserBundle\DataFixtures\Faker\Provider;

use ApiBundle\Bundle\UserBundle\Services\RolesHelper;
use Faker\Generator;
use Faker\Provider\Base as BaseProvider;

/**
 * Class UserProvider.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class UserProvider extends BaseProvider
{
    /** @var RolesHelper */
    private $rolesHelper;

    /** @var array */
    private $roleCount = [];

    /**
     * The first call generate unique values. This is to ensure all values are called before generating deplicates.
     *
     * @return string Random Symfony role.
     */
    public function userRole()
    {
        $roles        = $this->rolesHelper->getRoles();
        $returnedRole = $roles[array_rand($roles)];

        if (count($roles) !== count($this->roleCount)) {
            // Not all values have been generated yet
            // Get item that have not been used yet
            while (in_array($returnedRole, $this->roleCount)) {
                $returnedRole = $roles[array_rand($roles)];
            }
            $this->roleCount[] = $returnedRole;
        }

        return $returnedRole;
    }

    /**
     * @param Generator   $generator
     * @param RolesHelper $rolesHelper
     */
    public function __construct(Generator $generator, RolesHelper $rolesHelper)
    {
        parent::__construct($generator);
        $this->rolesHelper = $rolesHelper;
    }
}
