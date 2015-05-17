<?php

namespace ApiBundle\Tests\DataFixtures\Faker\Provider;

use ApiBundle\DataFixtures\Faker\Provider\JobProvider;

/**
 * Class JobProviderTest.
 *
 * @coversDefaultClass ApiBundle\DataFixtures\Faker\Provider\JobProvider
 *
 * @author             Théo FIDRY <theo.fidry@gmail.com>
 */
class JobProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Since tested values are random, they are tested a number of times. This constant is the number of iterations.
     *
     * @var int
     */
    const N = 500;

    /**
     * @var JobProvider
     */
    protected $provider;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->provider = new JobProvider(\Faker\Factory::create());
    }

    /**
     * Test the provider's methods.
     *
     * @covers ::jobTitle
     * @covers ::jobAbbreviation
     */
    public function testProvider()
    {
        for ($i = 0; $i <= self::N; $i++) {
            $this->assertEquals('string', gettype($this->provider->jobTitle()), 'Expected string value.');
            $this->assertEquals('string', gettype($this->provider->jobAbbreviation()), 'Expected string value.');
        }
    }
}
