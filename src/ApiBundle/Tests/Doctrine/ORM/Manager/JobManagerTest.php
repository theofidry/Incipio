<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Tests\Doctrine\ORM;

use ApiBundle\Doctrine\ORM\Manager\JobManager;
use ApiBundle\Doctrine\ORM\Manager\UserManager;
use ApiBundle\Entity\Job;
use ApiBundle\Entity\User;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Util\CanonicalizerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * @coversDefaultClass ApiBundle\Doctrine\ORM\Manager\JobManager
 *
 * @author             Théo FIDRY <theo.fidry@gmail.com>
 */
class JobManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::updateAbbreviation
     * @dataProvider jobProvider
     */
    public function testUpdateAbbreviation(Job $job, $expected)
    {
        $objectManager = $this->prophesize(EntityManagerInterface::class);
        $jobManager = new JobManager($objectManager->reveal());
        $jobBefore = clone $job;

        $jobManager->updateAbbreviation($job);

        $this->assertEquals($expected, $job->getAbbreviation());

        $job->setAbbreviation($jobBefore->getAbbreviation());
        $this->assertEquals(
            $jobBefore,
            $job,
            'Expected JobManager::updateAbbreviation() to only update Job#abbreviation'
        );
    }

    public function jobProvider()
    {
        return [
            [
                (new Job())
                    ->setAbbreviation('Abbreviation')
                ,
                'Abbreviation'
            ],
            [
                (new Job())
                    ->setTitle('President')
                ,
                'Pres'
            ],
            [
                (new Job())
                    ->setTitle('Data Analysist')
                ,
                'DA'
            ],
        ];
    }
}
