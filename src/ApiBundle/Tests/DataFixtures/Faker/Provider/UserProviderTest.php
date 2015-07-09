<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Tests\DataFixtures\Faker\Provider;

use ApiBundle\DataFixtures\Faker\Provider\UserProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class UserProviderTest.
 *
 * @coversDefaultClass ApiBundle\DataFixtures\Faker\Provider\UserProvider
 *
 * @author             Théo FIDRY <theo.fidry@gmail.com>
 */
class UserProviderTest extends KernelTestCase
{
    /**
     * Since tested values are random, they are tested a number of times. This constant is the number of iterations.
     *
     * @var int
     */
    const N = 500;

    /**
     * @var UserProvider
     */
    private $provider;

    /**
     * @var array List of known roles by the application.
     */
    private $roles = [];

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        self::bootKernel();
        $this->provider = self::$kernel->getContainer()->get('faker.provider.user');
        $this->roles = self::$kernel->getContainer()->get('api.user.roles')->getRoles();
    }

    /**
     * Test the provider's methods.
     *
     * @covers ::userRole
     */
    public function testProvider()
    {
        for ($i = 0; $i <= self::N; $i++) {
            $this->assertTrue(in_array($this->provider->userRole(), $this->roles), 'Expected to generate a known role');
        }
    }
}
