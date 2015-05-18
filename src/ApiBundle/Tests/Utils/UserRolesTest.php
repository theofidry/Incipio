<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Tests\Utils;

use ApiBundle\Utils\UserRoles;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class UserRolesTest.
 *
 * @coversDefaultClass ApiBundle\Utils\UserRoles
 *
 * @author             Théo FIDRY <theo.fidry@gmail.com>
 */
class UserRolesTest extends KernelTestCase
{
    /**
     * @var UserRoles
     */
    private $service;

    /**
     * @var array List of roles used in the system.
     */
    private $roles = [
        'ROLE_ALLOWED_TO_SWITCH',
        'ROLE_USER',
        'ROLE_ADMIN',
        'ROLE_SUPER_ADMIN',
    ];

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        self::bootKernel();
        $this->service = self::$kernel->getContainer()->get('api.user.roles');
    }

    /**
     * Test the service's methods.
     *
     * @covers ::getRoles
     */
    public function testService()
    {
        $serviceRoles = $this->service->getRoles();

        foreach ($this->roles as $role) {
            $this->assertTrue(in_array($role, $serviceRoles), "Role $role was expected to be found by the service.");
        }
    }
}
