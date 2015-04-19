<?php

namespace ApiBundle\Bundles\UserBundle\DataFixtures\ORM;

use Hautelook\AliceBundle\Alice\DataFixtureLoader;

/**
 * Class DataLoader: class loading fixtures.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class DataLoader extends DataFixtureLoader
{
    /**
     * @return string Random Symfony role.
     */
    public function role()
    {
        $roles = $this->container->get('api.user.roles')->getRoles();

        return $roles[array_rand($roles)];
    }

    /**
     * {@inheritDoc}
     */
    protected function getFixtures()
    {
        return [
            __DIR__.'/user.yml',
        ];
    }
}
