<?php

namespace ApiBundle\Bundles\UserBundle\Tests\Faker\Provider;

use ApiBundle\Bundles\UserBundle\DataFixtures\Faker\Provider\UserProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class UserProviderTest.
 *
 * @see    ApiBundle\Bundles\UserBundle\Faker\Provider\UserProvider
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
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
        $rolesHelper    = self::$kernel->getContainer()->get('api.user.roles');
        $this->provider = new UserProvider(\Faker\Factory::create(), $rolesHelper);
        $this->roles    = $rolesHelper->getRoles();
    }

    /**
     * Test the provider's methods.
     */
    public function testProvider()
    {
        for ($i = 0; $i <= self::N; $i++) {
            $this->assertTrue(in_array($this->provider->userRole(), $this->roles), 'Expected to generate a known role');
        }
    }
}
