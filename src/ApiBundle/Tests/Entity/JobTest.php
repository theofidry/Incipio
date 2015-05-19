<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Tests\Entity;

use ApiBundle\Entity\Job;
use ApiBundle\Entity\Mandate;
use ApiBundle\Entity\User;
use ApiBundle\Test\Entity\AbstractEntityTestCase;

/**
 * Class JobTest.
 *
 * @coversDefaultClass ApiBundle\Entity\Job
 *
 * @author             Théo FIDRY <theo.fidry@gmail.com>
 */
class JobTest extends AbstractEntityTestCase
{
    /**
     * {@inheritdoc}
     *
     * @covers       ::setTitle
     * @covers       ::getTitle
     * @covers       ::setAbbreviation
     * @covers       ::getAbbreviation
     * @covers       ::setEnabled
     * @covers       ::getEnabled
     * @covers       ::setUser
     * @covers       ::getUser
     * @covers       ::setMandate
     * @covers       ::getMandate
     * @dataProvider fluentDataProvider
     *
     * TODO: test on real database
     */
    public function testPropertyAccessors(array $data = [])
    {
        $job = new Job();

        $job
            ->setTitle($data['title'])
            ->setAbbreviation($data['abbreviation'])
            ->setEnabled($data['enabled'])
            ->setUser($data['user'])
            ->setMandate($data['mandate'])
        ;

        // Test classic setters
        $this->assertEquals($data['title'], $job->getTitle());
        $this->assertEquals($data['abbreviation'], $job->getAbbreviation());
        $this->assertEquals($data['enabled'], $job->getEnabled());
        $this->assertEquals($data['user'], $job->getUser());
        $this->assertEquals($data['mandate'], $job->getMandate());

        // Test if relations has been properly set
        $this->assertTrue($data['user']->getJobs()->contains($job));
        $this->assertTrue($data['mandate']->getJobs()->contains($job));

        // Test if properties and relations can be reset
        $job
            ->setTitle(null)
            ->setAbbreviation(null)
            ->setEnabled(null)
            ->setUser(null)
            ->setMandate(null)
        ;

        $this->assertEquals(null, $job->getTitle());
        $this->assertEquals(null, $job->getAbbreviation());
        $this->assertEquals(null, $job->getEnabled());
        $this->assertEquals(null, $job->getUser());
        $this->assertEquals(null, $job->getMandate());

        $this->assertFalse($data['user']->getJobs()->contains($job));
        $this->assertFalse($data['mandate']->getJobs()->contains($job));

        // Test if resetting non existing relations does not cause any error
        $job
            ->setUser(null)
            ->setMandate(null)
        ;
        $this->assertEquals(null, $job->getUser());
        $this->assertEquals(null, $job->getMandate());
    }

    /**
     * Provides an optimal set of data for generating a complete entity.
     */
    public function fluentDataProvider()
    {
        return [
            [
                [
                    'title' => 'President',
                    'abbreviation' => 'Pres',
                    'enabled' => true,
                    'user' => new User(),
                    'mandate' => new Mandate(),
                ],
            ],
        ];
    }
}
