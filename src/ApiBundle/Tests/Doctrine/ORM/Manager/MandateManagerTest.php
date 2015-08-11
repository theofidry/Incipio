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
use ApiBundle\Doctrine\ORM\Manager\MandateManager;
use ApiBundle\Doctrine\ORM\Manager\UserManager;
use ApiBundle\Entity\Job;
use ApiBundle\Entity\Mandate;
use ApiBundle\Entity\User;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Util\CanonicalizerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * @coversDefaultClass ApiBundle\Doctrine\ORM\Manager\MandateManager
 *
 * @author             Théo FIDRY <theo.fidry@gmail.com>
 */
class MandateManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::updateName
     * @dataProvider mandateProvider
     */
    public function testUpdateAbbreviation(Mandate $mandate, $expected)
    {
        $objectManager = $this->prophesize(EntityManagerInterface::class);
        $mandateManager = new MandateManager($objectManager->reveal());
        $mandateBefore = clone $mandate;

        $mandateManager->updateName($mandate);

        $this->assertEquals(
            $expected['value'],
            $mandate->getName(),
            $expected['message']
        );

        $mandate->setName($mandateBefore->getName());
        $this->assertEquals(
            $mandateBefore,
            $mandate,
            'Expected MandateManager::updateName() to only update Job#abbreviation'
        );
    }

    public function mandateProvider()
    {
        return [
            [
                (new Mandate())
                    ->setStartAt(
                        (new \DateTime())
                            ->setDate(2000, 01, 01)
                    )
                    ->setEndAt(
                        (new \DateTime())
                            ->setDate(2001, 01, 01)
                    )
                ,
                [
                    'value'   => 'Mandate 2000/2001',
                    'message' => 'Expected a name with the mask \'Mandate startYear/endYear\'',
                ]
            ],
            [
                (new Mandate())
                    ->setStartAt(
                        (new \DateTime())
                            ->setDate(2000, 01, 01)
                    )
                    ->setEndAt(
                        (new \DateTime())
                            ->setDate(2000, 05, 01)
                    )
                ,
                [
                    'value'   => 'Mandate 01 2000',
                    'message' => 'Expected a name with the mask \'Mandate startMonth Year\'',
                ]
            ],
        ];
    }
}
