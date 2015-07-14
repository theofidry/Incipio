<?php

namespace ApiBundle\Tests\DataFixtures\Faker\Provider;

use ApiBundle\DataFixtures\Faker\Provider\StudentConventionProvider;

/**
 * @coversDefaultClass ApiBundle\DataFixtures\Faker\Provider\StudentConventionProvider
 *
 * @author             Théo FIDRY <theo.fidry@gmail.com>
 */
class StudentConventionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var StudentConventionProvider
     */
    protected $provider;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->provider = new StudentConventionProvider();
    }

    /**
     * @testdox Test the UserProvider::generateReference
     *
     * @covers ::generateReference
     * @dataProvider referenceProvider
     *
     * @param           $fullname
     * @param \DateTime $dateOfSignature
     * @param           $expected
     */
    public function testGenerateReference($fullname, \DateTime $dateOfSignature, $expected)
    {
        $this->assertEquals($expected, $this->provider->generateReference($dateOfSignature, $fullname));
    }

    public function referenceProvider()
    {
        return [
            [
                'John Doe',
                new \DateTime('2015-01-31'),
                'JOHDOE20150131',
            ],
            [
                'A Lodoni',
                new \DateTime('2015-01-31'),
                'ALODAB20150131',
            ],
            [
                'Alexander A',
                new \DateTime('2015-01-31'),
                'ALEAAB20150131',
            ],
            [
                'Pi A',
                new \DateTime('2015-01-31'),
                'PIAABC20150131',
            ],
            [
                '',
                new \DateTime('2015-01-31'),
                'ABCDEF20150131',
            ],
            [
                'Jean-Reneau Baptiste',
                new \DateTime('2015-01-31'),
                'JEABAP20150131',
            ],
            [
                'Dr. Uriah Okuneva',
                new \DateTime('2015-01-31'),
                'DRURIO20150131',
            ],
        ];
    }
}
