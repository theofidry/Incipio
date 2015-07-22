<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Tests\Doctrine;

use ApiBundle\Doctrine\UserManager;
use ApiBundle\Entity\User;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Util\CanonicalizerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * @coversDefaultClass ApiBundle\Doctrine\UserManager

 * @author             Théo FIDRY <theo.fidry@gmail.com>
 */
class UserManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::updateCanonicalFields
     */
    public function testUpdateCanonicalFields()
    {
        $user = (new User())
            ->setEmail('email@example.com')
            ->setUsername('My Username')
            ->setOrganizationEmail('organization@example.com')
        ;
        $class = get_class($user);

        $encoderFactory = $this->prophesize(EncoderFactoryInterface::class);
        $usernameCanonicalizer = $this->prophesize(CanonicalizerInterface::class);
        $usernameCanonicalizer->canonicalize('My Username')->willReturn('canonicalUsername');
        $emailCanonicalizer = $this->prophesize(CanonicalizerInterface::class);
        $emailCanonicalizer->canonicalize('email@example.com')->willReturn('canonicalEmail');
        $emailCanonicalizer->canonicalize('organization@example.com')->willReturn('canonicalOrganisationEmail');

        $metadata = $this->prophesize(ClassMetadata::class);
        $metadata->getName()->willReturn($class);

        $objectManager = $this->prophesize(ObjectManager::class);
        $objectManager->getRepository($class)->willReturn('\Doctrine\ORM\EntityRepository');
        $objectManager->getClassMetadata($class)->willReturn($metadata->reveal());

        $userManager = new UserManager(
            $encoderFactory->reveal(),
            $usernameCanonicalizer->reveal(),
            $emailCanonicalizer->reveal(),
            $objectManager->reveal(),
            $class
        );

        $userManager->updateCanonicalFields($user);

        $this->assertEquals('email@example.com', $user->getEmail());
        $this->assertEquals('canonicalEmail', $user->getEmailCanonical());
        $this->assertEquals('organization@example.com', $user->getOrganizationEmail());
        $this->assertEquals('canonicalOrganisationEmail', $user->getOrganizationEmailCanonical());
        $this->assertEquals('My Username', $user->getUsername());
        $this->assertEquals('canonicalUsername', $user->getUsernameCanonical());
    }
}
